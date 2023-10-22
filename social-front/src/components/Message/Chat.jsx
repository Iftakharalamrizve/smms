import React,{useState} from 'react'
import { Box, List, Item, Icon, Text, Form, Button, Input, MessageTime } from "@components/elements";
import { DuelText, RoundAvatar } from "@components";
import {CardLayout} from "@components/cards";
import { useDispatch } from 'react-redux';
import { messageReply } from "@store/actions/fbMessageAction";
import data from "../../data/master/message.json";

export default function Chat({chatData, currentActiveSessionId, pageId}) {
  const dispatch = useDispatch();
  const [replyText, setAgentReplyText] = useState("")
    const ChatItemFormat = (itemList, direction, index) => (
          
          <Item key={index} className={direction === 'IN' ? 'mc-message-chat-item' : 'mc-message-chat-item-right'}>
              <Box className="mc-message-chat-group">
              {itemList}
              </Box>
          </Item>
    );
    const ChatGroupTextItemList = ({ listItem }) => {
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
              let uniqueKey = index+prevItem.direction;
              console.log(uniqueKey);
              ChatGroupItemList.push(ChatItemFormat(groupByMessageList, prevItem.direction, uniqueKey));
              groupByMessageList = [];
            }
            
            const messageGroupItem = (
              <Box key={messageItem.start_time}  className="mc-message-chat-text">
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
              let uniqueKey2 = index+messageItem.direction;
              console.log(uniqueKey2);
              ChatGroupItemList.push(ChatItemFormat(groupByMessageList, messageItem.direction, uniqueKey2));
            }
          });
        
          return <>{ChatGroupItemList}</>;
    };

    const sendCustomerGeneralReply = () => {
      if(replyText){
        let messageData = {
          session_id:currentActiveSessionId,
          page_id: pageId,
          reply: replyText
        }
        dispatch(messageReply(messageData));
        setAgentReplyText("");
      }
    }

    return (
        <CardLayout>
            <Box className="mc-message-chat">
                <Box className="mc-message-chat-header">
                    <RoundAvatar src="images/avatar/01.webp" alt="avatar" size="xs" />
                    <DuelText title="miron mahmud" descrip="active now" size="xs" gap="4px" />
                    <Box className="mc-message-chat-action-group">
                        {data?.actions.map((item, index) => (
                            <Icon 
                                key={ index } 
                                type={ item.icon } 
                                title={ item.title }
                                onClick={ item.event } 
                            />
                        ))}
                    </Box>
                </Box>
                <List key={pageId}  className="mc-message-chat-list thin-scrolling">
                    <ChatGroupTextItemList listItem= {chatData} />
                </List>
                <Form className="mc-message-chat-footer">
                    <Input type="text" onChange={(value)=>{setAgentReplyText(value)}} value={replyText} placeholder="Type a message"></Input>
                    <Button type="button" className="disposition material-icons" title="Disposition Reply">grading</Button>
                    <Button  onClick={()=>{sendCustomerGeneralReply()}} type="button" title="Send Reply" className="material-icons">send</Button>
                </Form>
            </Box>
        </CardLayout>
    )
}
