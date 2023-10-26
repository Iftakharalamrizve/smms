import React from 'react'
import { Box, Item, Text, MessageTime } from "@components/elements";

export default function ChatGroupTextItemList({ listItem }) {
    return listItem?.map((messageItem, index) => {
        const prevItem = index > 0 ? listItem[index - 1] : null;
        const chatItem = (
          <Item
            key={`${messageItem.start_time}-${messageItem.direction}`}
            className={
              messageItem.direction === 'IN'
                ? 'mc-message-chat-item'
                : 'mc-message-chat-item-right'
            }
          >
            {prevItem &&
              prevItem.direction !== messageItem.direction && (
                <Text className="mc-message-chat-datetime">
                  <MessageTime time={prevItem.start_time} />
                </Text>
              )}
    
            <Box className="mc-message-chat-group">
              <Box key={messageItem.start_time} className="mc-message-chat-text">
                <Text>{messageItem.message_text}</Text>
              </Box>
    
              {index === listItem.length - 1 && (
                <Text className="mc-message-chat-datetime">
                  <MessageTime time={messageItem.start_time} />
                </Text>
              )}
            </Box>
          </Item>
        );
    
        return chatItem;
    });
}
