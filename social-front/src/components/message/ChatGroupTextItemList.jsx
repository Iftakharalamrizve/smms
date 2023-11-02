import React from 'react'
import { Box, Item, Text, MessageTime } from "@components/elements";

export default function ChatGroupTextItemList({ listItem }) {
  const ChatItemFormat = (itemList, direction, index) => (

    <Item key={index} className={direction === 'IN' ? 'mc-message-chat-item' : 'mc-message-chat-item-right'}>
      <Box className="mc-message-chat-group">
        {itemList}
      </Box>
    </Item>
  );

  let ChatGroupItemList = [];
  let groupByMessageList = [];

  listItem?.forEach((messageItem, index) => {
    const prevItem = index > 0 ? listItem[index - 1] : null;

    if (prevItem && prevItem.direction !== messageItem.direction) {
      groupByMessageList.push(
        <Text key={index} className="mc-message-chat-datetime">
          <MessageTime time={prevItem.start_time} />
        </Text>
      );
      let uniqueKey = index + prevItem.direction;
      ChatGroupItemList.push(ChatItemFormat(groupByMessageList, prevItem.direction, uniqueKey));
      groupByMessageList = [];
    }

    const messageGroupItem = (
      <Box key={messageItem.start_time} className="mc-message-chat-text">
        <Text>{messageItem.message_text}</Text>
      </Box>
    );
    groupByMessageList.push(messageGroupItem);
    if (index === listItem.length - 1) {
      groupByMessageList.push(
        <Text key={index} className="mc-message-chat-datetime">
          <MessageTime time={messageItem.start_time} />
        </Text>
      );
      let uniqueKey2 = index + messageItem.direction;
      ChatGroupItemList.push(ChatItemFormat(groupByMessageList, messageItem.direction, uniqueKey2));
    }
  });

  return <>{ChatGroupItemList}</>;
}
