<?php

namespace App\Repositories;

use App\Models\SocialMessage;

class SocialMessageRepository
{

    public function getCustomerLastMessageWithDuration($durationCondition, $customerId, $pageId)
    {
        $lastMessage = SocialMessage::where('customer_id', $customerId)
                    ->where('page_id', $pageId)
                    ->where('created_at', '>=', $durationCondition)
                    ->where('sms_state','!=','Queue')
                    ->latest('created_at')
                    ->first();
        return $lastMessage;
    }


    public function getSpecificMessage($condtionArray)
    {
        return SocialMessage::where($condtionArray)->latest()->first();
        if ($item) {
            // Update the item
            $item->update([
                'sms_state' => 'RRQueue',
            ]);
        
            $item->refresh();
        
            // Return the updated item
            return $item;
        } else {
            // Handle the case when no item is found
            return null;
        }
    }

    /**
     *
     *
     * 
     * @todo exception handle
     */
    public function save($data = [])
    {
        try {

            return SocialMessage::create($data);
        } catch (\Exception $e) {
            //throw $th;
            dd($e->getMessage());
        }
    }
    
    /**
     *
     *
     * 
     * @todo exception handle
     */
    public function update($updateObject, $data = [])
    {
        try {
            return $updateObject->update($data);
        } catch (\Exception $e) {
            //throw $th;
            dd($e->getMessage());
        }
    } 
}
