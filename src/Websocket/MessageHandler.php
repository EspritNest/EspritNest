<?php
namespace App\Websocket;

use Exception;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Messages;
use App\Entity\Discussions;
use App\Entity\Utilisateur;

class MessageHandler implements MessageComponentInterface
{
    
    protected $connections;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->connections = new SplObjectStorage;
        $this->entityManager = $entityManager;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        // Example: Assign a temporary ID based on a query parameter for demonstration purposes.
        // You can implement proper authentication to associate the user.
        $query = $conn->httpRequest->getUri()->getQuery();
        parse_str($query, $params);
        $userId = $params['userId'] ?? null;

        if ($userId) {
            $conn->userId = $userId;
        }

        $this->connections->attach($conn);
        foreach ($this->connections as $client) {
            if ($client !== $conn) {
                $statusMessage = json_encode([
                    'type' => 'status',
                    'userId' => $userId,
                    'status' => 'connected'
                ]);
        
                if ($statusMessage === false) {
                    error_log('JSON encoding error: ' . json_last_error_msg());
                    continue;
                }
        
                $client->send($statusMessage);
            }
        }
        
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
    
        // Check if the message is a status message
        if (isset($data['type']) && $data['type'] === 'status') {
            // Handle status messages separately if necessary
            // For example, log or broadcast the status update
            error_log('Status message received: ' . print_r($data, true));
            return;
        }
    
        // Now process normal chat messages
        if (isset($data['to'], $data['content'], $data['discussionId'])) {
            $recipientId = $data['to'];
            $message = $data['content'];
            $discussionId = $data['discussionId'];
    
            // Save the message to the database
            $discussion = $this->entityManager->getRepository(Discussions::class)->find($discussionId);
            $sender = $this->entityManager->getRepository(Utilisateur::class)->find($data['from']);
            if ($discussion && $sender) {
                $messageEntity = new Messages();
                $messageEntity->setSender($sender);
                $messageEntity->setSentAt(new \DateTime());
                $messageEntity->setContent($message);
                $messageEntity->setDiscussion($discussion);
                $this->entityManager->persist($messageEntity);
                $this->entityManager->flush();
    
                // Send the message to the recipient
                foreach ($this->connections as $client) {
                    if ($client->userId === $recipientId) {
                        $client->send(json_encode([
                            'from' => $data['from'],
                            'content' => $message,
                            'discussionId' => $discussionId,
                        ]));
                        return;
                    }
                }
    
                // If the recipient is not connected, send an error
                $from->send(json_encode([
                    'error' => 'Recipient not connected.',
                ]));
            } else {
                // If the discussion or sender is invalid, send an error
                $from->send(json_encode([
                    'error' => 'Invalid discussion ID or sender ID.',
                ]));
                error_log('Invalid discussion ID or sender ID: ' . print_r($data, true));
            }
        } else {
            // Handle invalid message format
            $from->send(json_encode([
                'error' => 'Invalid message format.',
            ]));
            error_log('Invalid message format: ' . print_r($data, true));
        }
    }
    
    public function onClose(ConnectionInterface $conn)
    {
        $this->connections->detach($conn);
        foreach ($this->connections as $client) {
            $client->send(json_encode(['type' => 'status', 'userId' => $conn->userId, 'status' => 'disconnected']));
        }
    }

    public function onError(ConnectionInterface $conn, Exception $e)
    {
        $this->connections->detach($conn);
        $conn->close();
    }
}