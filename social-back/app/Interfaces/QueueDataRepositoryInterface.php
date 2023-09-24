<?php

namespace App\Interfaces;

interface QueueDataRepositoryInterface{

    /**
     * Create a new queue with the given name.
     *
     * @param string $queueName The name of the queue to be created.
     * @return void
     */
    public function createQueue($queueName);

    /**
     * Delete an existing queue with the given name.
     *
     * @param string $queueName The name of the queue to be deleted.
     * @return void
     */
    public function deleteQueue($queueName);

    /**
     * Push a message to the right end of the queue.
     *
     * @param string $queueName The name of the queue.
     * @param string $message The message to be pushed.
     * @return void
     */
    public function queueRightPush($queueName, $message);

    /**
     * Push a message to the left end of the queue.
     *
     * @param string $queueName The name of the queue.
     * @param string $message The message to be pushed.
     * @return void
     */
    public function queueLeftPush($queueName, $message);

    /**
     * Remove and return the leftmost message from the queue.
     *
     * @param string $queueName The name of the queue.
     * @return string|null The leftmost message, or null if the queue is empty.
     */
    public function queueLeftPop($queueName);

    /**
     * Remove and return the rightmost message from the queue.
     *
     * @param string $queueName The name of the queue.
     * @return string|null The rightmost message, or null if the queue is empty.
     */
    public function queueRightPop($queueName);

    /**
     * Retrieve a range of messages from the queue.
     *
     * @param string $queueName The name of the queue.
     * @param int $startPosition The starting position of the range.
     * @param int $endPosition The ending position of the range.
     * @return array An array of messages within the specified range.
     */
    public function queueListRange($queueName, $startPosition, $endPosition);
    

    /**
     * Retrieve list of item from the queue.
     *
     * @param string $key The key name of the queue.
     * @return array An array return list of item from redis.
     */
    public function queueRetriveListByKey($key);

}