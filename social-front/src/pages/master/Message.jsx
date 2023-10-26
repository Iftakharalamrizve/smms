import React,{ useEffect, useState } from "react";
import { Row, Col, Tab, Tabs } from "react-bootstrap";
import { Box, List, Item, Icon, Text, Form, Button, Input, MessageTime } from "@components/elements";
import { DotsMenu, DuelText, RoundAvatar,Chat } from "@components";
import {CardLayout,TabCard} from "@components/cards";
import IconField from "@components/fields/IconField";
import { useCurrentAgentMessageList, useGetUserInfo, usecurrentActiveSessionList} from '@src/hooks';
import PageLayout from "../../layouts/PageLayout"; 
import data from "../../data/master/message.json";
import { useWebSocket } from '../../context/WebSocketContext';
import { currentUserMessageSessionList, sessionMessageHisoty } from "../../store/actions/fbMessageAction";
import { agentCurrentModeSetAndGet } from "../../store/actions/agentAction";
import {setMessageSession} from "@reducer/fbMessage"
import { useDispatch } from 'react-redux';



export default function Message() {
    const { socketInstance } = useWebSocket();
    const dispatch = useDispatch();
    const facebookMessageList = useCurrentAgentMessageList();
    console.log(facebookMessageList);
    const currentAgentId = useGetUserInfo('agent_id');
    const currentActiveSessionList = usecurrentActiveSessionList('activeSessionList');
    const sessionMessageDetails = usecurrentActiveSessionList('detailsMessageList');
    const action  = [
        { "icon": "account_circle", "text": "view profile" },
        { "icon": "mark_chat_read", "text": "mark as unread" },
        { "icon": "delete", "text": "delete messages" },
        { "icon": "remove_circle", "text": "block messages" }
    ];

    useEffect(() => {
        dispatch(agentCurrentModeSetAndGet());
        dispatch(currentUserMessageSessionList());
    },[]);

    useEffect(() => {
        async function connectWithChannel() {
          if(socketInstance){
            socketInstance.private(`social_chat_room.`+currentAgentId)
            .listen('.agent_chat_room_event', (event) => {
                dispatch(setMessageSession(event))
            })
            .listenForWhisper('typing', (e) => {
                
            })
            .error((error) => {
                console.error(error);
            });
          }
        }
        connectWithChannel();
    }, [socketInstance]);

    const getSessionMessageHistory = (item) =>{
        const {session_id, page_id} = item;
        dispatch(sessionMessageHisoty({session_id,page_id}));
    }

    const generateSessionMessageItemList = (data) => {
        let itemList = [];
    
        for (const sessionId in data) {
            let item = data[sessionId];
            console.log(item,"dsf");
            let SessionItem = (
                <Item
                    key={sessionId}
                    onClick={() => {
                        getSessionMessageHistory(data[sessionId]);
                    }}
                    className={`mc-message-user-item ${item.session_id === currentActiveSessionList[item.page_id] ? 'active' : ''}`}
                >
                    <DuelText
                        title={item.customer_id}
                        timesTamp={<MessageTime time={item.start_time} />}
                        descrip={item.message_text}
                        size="xs"
                        gap="4px"
                    />
                    {item.un_read_count != 0 ? <Text as="sup">{item.un_read_count}</Text>:null}
                    <DotsMenu dots="more_vert" dropdown={action} />
                </Item>
            );
            itemList.push(SessionItem);
        }
        return itemList;
    }
 
    return (
        <PageLayout>
            <Row>
                <Col xl={12}>
                    <CardLayout>
                        { data?.platforms.length > 0 ?<>
                                <Tabs defaultActiveKey="fb"   className="mc-tabs social-tabs">
                                    {data?.platforms.map((item,index)=>(
                                        <Tab eventKey={item.key} title={item.title} className="mc-tabpane profile social-tab" key={index}>
                                            {   item?.pages.length > 0 ?<>
                                                    <Tabs defaultActiveKey="gs"  className="mc-tabs social-sub-tabs" >
                                                        {item?.pages.map((list,index)=>(
                                                            <Tab eventKey={list.key} title={list.title} className="mc-tabpane profile social-sub-tab" key={index}>
                                                                <Tabs defaultActiveKey="post"  className="mc-tabs social-sub-tabs" >
                                                                    <Tab eventKey="post" title="Post" className="mc-tabpane profile social-sub-tab">
                                                                        <h1>Gplex Post</h1>
                                                                    </Tab>
                                                                    <Tab eventKey="message" title="Message" className="mc-tabpane profile social-sub-tab">
                                                                        <Row>
                                                                            <Col md={5} xl={4}>
                                                                                <CardLayout className="p-0">
                                                                                    <Box className="mc-message-user">
                                                                                        <Box className="mc-message-user-filter">
                                                                                            <IconField 
                                                                                                type={ data?.search.type }
                                                                                                icon={ data?.search.icon }
                                                                                                classes={ data?.search.fieldSize }
                                                                                                placeholder={ data?.search.placeholder }
                                                                                            />
                                                                                            <DotsMenu 
                                                                                                dots={ data?.dots.icon }
                                                                                                dropdown={ data?.dots.menu } 
                                                                                            />
                                                                                        </Box>
                                                                                        <List className="mc-message-user-list thin-scrolling">
                                                                                            {generateSessionMessageItemList(facebookMessageList[list.id])}
                                                                                        </List>
                                                                                    </Box>
                                                                                </CardLayout>
                                                                            </Col>
                                                                            <Col md={7} xl={8}>
                                                                                
                                                                                {currentActiveSessionList[list.id]?<Chat currentActiveSessionId={currentActiveSessionList[list.id]} chatData={sessionMessageDetails[list.id]} pageId = {list.id} />:<></>}
                                                                            </Col>
                                                                        </Row>
                                                                    </Tab>
                                                                </Tabs>
                                                            </Tab>
                                                        ))}
                                                    </Tabs>
                                                </>:null
                                            }
                                        </Tab>
                                    ))}
                                </Tabs>
                            </>:null
                        }
                    </CardLayout>
                </Col>
            </Row>
        </PageLayout>
    )
}