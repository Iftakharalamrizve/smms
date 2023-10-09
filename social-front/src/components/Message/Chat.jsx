import React from 'react'
import { Box, List, Item, Icon, Text, Form, Button, Input, MessageTime } from "../../components/elements";
import { DuelText, RoundAvatar } from "../../components";
import {CardLayout} from "@components/cards";
import data from "../../data/master/message.json";

export default function Chat({chatData}) {
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
            <List className="mc-message-chat-list thin-scrolling">
                {data?.chats.map((chat, index) => (
                    <Item key={ index } className="mc-message-chat-item">
                        <RoundAvatar src={ chat.src } alt="avatar" size="mc-message-chat-user" />
                        <Box className="mc-message-chat-group">
                            {chat.text.map((message, index) => (
                                <Box key={ index } className="mc-message-chat-text">
                                    <Text key={ index }>{ message.text }</Text>
                                    {message.icon.map((icon, index) => (
                                        <Icon key={ index } type={ icon } />
                                    ))}
                                </Box>
                            ))}
                            <Text className="mc-message-chat-datetime">{ chat.time }</Text>
                        </Box>
                    </Item>
                ))}
            </List>
            <Form className="mc-message-chat-footer">
                <Input type="text" placeholder="Type a message"></Input>
                <Button type="button" className="material-icons">send</Button>
            </Form>
        </Box>
    </CardLayout>
  )
}
