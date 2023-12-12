<?php

namespace App\Repositories;

use App\Helpers\HelperService;
use App\Interfaces\QueueDataRepositoryInterface;
use Illuminate\Support\Facades\Redis;

class QueueRepository implements QueueDataRepositoryInterface
{
    /**
     * Create a new queue with the given name.
     *
     * @param string $queueName The name of the queue to be created.
     * @return void
     */
    public function createQueue($queueName)
    {
        // Create a blank list or set
        Redis::del($queueName);
        Redis::lpush($queueName, '');
    } 

    /**
     * Delete an existing queue with the given name.
     *
     * @param string $queueName The name of the queue to be deleted.
     * @return void
     */
    public function deleteQueue($queueName)
    {
        // Delete queue
        Redis::del($queueName);
    }

    /**
     * Push a message to the right end of the queue.
     *
     * @param string $queueName The name of the queue.
     * @param string $message The message to be pushed.
     * @return boolean
     */
    public function queueRightPush($queueName, $message)
    {
        // Right Push queue
        return Redis::rpush($queueName, $message);
    }

    /**
     * Push a message to the left end of the queue.
     *
     * @param string $queueName The name of the queue.
     * @param string $message The message to be pushed.
     * @return void
     */
    public function queueLeftPush($queueName, $message)
    {
        // Left Push queue
        Redis::lpush($queueName, $message);
    }

    /**
     * Remove and return the leftmost message from the queue.
     *
     * @param string $queueName The name of the queue.
     * @return string|null The leftmost message, or null if the queue is empty.
     */
    public function queueLeftPop($queueName)
    {
        // Left POP queue
        // $data = [];
        // $data[] =  Redis::lrange($queueName, 0, -1);
        // $data[] =  Redis::lpop($queueName);
        // $data[] =  Redis::lrange($queueName, 0, -1);
        // return $data;

        return Redis::lpop($queueName);
    }

    /**
     * Remove and return the rightmost message from the queue.
     *
     * @param string $queueName The name of the queue.
     * @return string|null The rightmost message, or null if the queue is empty.
     */
    public function queueRightPop($queueName)
    {
        // Right POP queue
        return Redis::rpop($queueName);
    }

    /**
     * Retrieve a range of messages from the queue.
     *
     * @param string $queueName The name of the queue.
     * @param int $startPosition The starting position of the range.
     * @param int $endPosition The ending position of the range.
     * @return array An array of messages within the specified range.
     */
    public function queueListRange($queueName, $startPosition, $endPosition)
    {
        // Range Item get from queue
        return Redis::lrange($queueName, $startPosition, $endPosition);
    }

    /**
     * Retrieve list of item from the queue.
     *
     * @param string $key The key name of the queue.
     * @return array An array return list of item from redis.
     */
    public function queueRetriveListByKey($key, $ignoreAgent=null)
    {
        HelperService::generateApiRequestResponseLog(["Key which want to pick "=>$key, '$ignoreAgent'=>$ignoreAgent]);
        try {
            if($ignoreAgent){
                $itemList = Redis::keys($key);
                $filteredKeys = array_filter($itemList, function ($item) use ($ignoreAgent) {
                    $allKeyExplode = explode(':', $item);
                    return $allKeyExplode[1] != $ignoreAgent;
                });
                return $filteredKeys;
            }
            return Redis::keys($key);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Chack Item is exist or not not in queue use queuename.
     *
     * @param string $key  not any pattern is applicablee.
     * @return boolean  true or false .
     */
    public function queueItemStatus($key)
    {
        return Redis::exists($key);
    }

    public function checkItemExistInQueue($queueKey, $value )
    {
        try {
            $status = Redis::executeRaw(['LPOS', $queueKey, $value]);
            return isset($status)? true: false;
        } catch (\Exception $e) {
            dd($e->getMessage());
            throw new \Exception($e->getMessage());
        }
    }

    public function queueLengthNumber($queueKey)
    {
        return Redis::llen($queueKey);
    }

    public function queueListSpecificItemRemove($queueName,$value)
    {
        return Redis::lrem($queueName, 0, $value);
    }

    public function setItemSpecificPosition($keyName, $position, $updatedData){
        Redis::lset($keyName, $position, json_encode($updatedData));
    }
}
