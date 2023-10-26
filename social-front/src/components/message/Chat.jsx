import React,{useState} from 'react'
import { Box, List, Item, Icon, Text, Form, Button, Input, MessageTime } from "@components/elements";
import { DuelText, RoundAvatar } from "@components";
import {CardLayout} from "@components/cards";
import {ChatGroupTextItemList, DispositionOperation} from "@components";
import { useDispatch } from 'react-redux';
import { messageReply } from "@store/actions/fbMessageAction";

export default function Chat({chatData, currentActiveSessionId, pageId}) {
    const dispatch = useDispatch();
    const [replyText, setAgentReplyText] = useState("");
    
    const [dispositionModalStatus,setDispositionStatus] = useState(false);

    const sendCustomerGeneralReply = (event) => {
      event.preventDefault();
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

    const handleDispositionModal = (status) => {
        setDispositionStatus(status);
    }

    return (
        <CardLayout>
            <Box className="mc-message-chat">
                <Box className="mc-message-chat-header">
                    <RoundAvatar src="images/avatar/01.webp" alt="avatar" size="xs" />
                    <DuelText title="miron mahmud" descrip="active now" size="xs" gap="4px" />
                </Box>
                <List key={pageId}  className="mc-message-chat-list thin-scrolling">
                    <ChatGroupTextItemList listItem= {chatData} />
                    {dispositionModalStatus && <DispositionOperation onModalChange={handleDispositionModal} modalStatus={dispositionModalStatus}  sessionId = {currentActiveSessionId} pageId = {pageId} />}
                </List>
                <Form onSubmit={event => sendCustomerGeneralReply(event)} className="mc-message-chat-footer">
                    <Input type="text" onChange={(value)=>{setAgentReplyText(value)}} value={replyText} placeholder="Type a message"></Input>
                    <Button type="button" onClick={()=>{setDispositionStatus(true)}} className="disposition material-icons" title="Disposition Reply">grading</Button>
                    <Button  onClick={event => sendCustomerGeneralReply(event)} type="button" title="Send Reply" className="material-icons">send</Button>
                </Form>
            </Box>
        </CardLayout>
    )
}
