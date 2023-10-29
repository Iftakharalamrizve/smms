import React, { useState } from 'react'
import { List, Item, MessageTime, Option, Heading, Box, Anchor, Button, Image, Input, Label, Icon, Text } from "@components/elements";
import { LabelField, LabelTextarea } from "../../components/fields";

import { DuelText, RoundAvatar } from "@components";
import { Modal, Form, Row, Col, Alert } from "react-bootstrap";
import { CardLayout } from "@components/cards";
import { ChatGroupTextItemList, DispositionOperation } from "@components";
import { useDispatch } from 'react-redux';
import { messageReply } from "@store/actions/fbMessageAction";

export default function Chat({ chatData, currentActiveSessionId, pageId }) {
    // const [dispositionModalStatus, setDispositionStatus] = useState(false);
    // const [replyText, setAgentReplyText] = useState("");
    // const [errorMsgShow, setErrorMessage] = useState(false);
    // const [replyDisText, setAgentDispositionReplyText] = useState("");
    // const [disposition, setDisposition] = useState("");

    // const sendCustomerGeneralReply = (event) => {
    //     event.preventDefault();
    //     if (replyText) {
    //         let messageData = {
    //             session_id: currentActiveSessionId,
    //             page_id: pageId,
    //             reply: replyText
    //         }
    //         dispatch(messageReply(messageData));
    //         setAgentReplyText("");
    //     }
    // }
    // const sendCustomerDispositionReply = () => {
    //     if(replyDisText && disposition){
    //       let messageData = {
    //         disposition_id: disposition,
    //         session_id:currentActiveSessionId,
    //         page_id: pageId,
    //         reply: replyDisText
    //       }
    //       handleStateValue(false);
    //       dispatch(messageReply(messageData));
    //       setAgentReplyText("");
    //       setDisposition("");
    //     }else{
    //       setErrorMessage(true);
    //     }
    //   }

    // const handleStateValue = (status) => {
    //     setDispositionStatus(status);  
    // }
    const dispatch = useDispatch();
    const [state, setState] = useState({
        dispositionModalStatus: false,
        replyText: "",
        errorMsgShow: false,
        replyDisText: "",
        disposition: "",
    });

    const sendMessage = (messageData) => {
        dispatch(messageReply(messageData));
        setState({
            ...state,
            replyText: "",
            replyDisText:"",
            disposition: "",
        });
    };

    const handleStateValue = (name,value) => {
        setState({ ...state, [name]: value });
    };

    const { dispositionModalStatus, replyText, errorMsgShow, replyDisText, disposition } = state;

    const sendCustomerGeneralReply = (event) => {
        event.preventDefault();
        if (replyText) {
            const messageData = {
                session_id: currentActiveSessionId,
                page_id: pageId,
                reply: replyText,
            };
            sendMessage(messageData);
        }
    };

    const sendCustomerDispositionReply = () => {
        if (replyDisText && disposition) {
            const messageData = {
                disposition_id: disposition,
                session_id: currentActiveSessionId,
                page_id: pageId,
                reply: replyDisText,
            };
            handleStateValue("dispositionModalStatus",false);
            sendMessage(messageData);
        } else {
            setState({ ...state, errorMsgShow: true });
        }
    };
    return (
        <>
            <CardLayout>
                <Box className="mc-message-chat">
                    <Box className="mc-message-chat-header">
                        <RoundAvatar src="images/avatar/01.webp" alt="avatar" size="xs" />
                        <DuelText title="miron mahmud" descrip="active now" size="xs" gap="4px" />
                    </Box>
                    <List key={pageId} className="mc-message-chat-list thin-scrolling">
                        <ChatGroupTextItemList listItem={chatData} />
                    </List>
                    <Form onSubmit={event => sendCustomerGeneralReply(event)} className="mc-message-chat-footer">
                        <Input type="text" onChange={(value) => { handleStateValue("replyText",value) }} value={replyText} placeholder="Type a message"></Input>
                        <Button type="button" onClick={()=>{handleStateValue("dispositionModalStatus",true)}} className="disposition material-icons" title="Disposition Reply">grading</Button>
                        <Button onClick={event => sendCustomerGeneralReply(event)} type="button" title="Send Reply" className="material-icons">send</Button>
                    </Form>
                </Box>
            </CardLayout>
            <Modal
                animation={true}
                show={dispositionModalStatus}
                onHide={()=>{handleStateValue("dispositionModalStatus",false)}}
                dialogClassName="modal-45w"
                aria-labelledby="example-modal-sizes-title-sm"
            >
                <Modal.Header closeButton>
                    <Modal.Title id="example-modal-sizes-title-sm">
                        Message Disposition
                    </Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <Box className="">
                        <Row>
                            <Col md={{ span: 4, offset: 4 }}>
                                <Image src={"http://localhost:3000/images/avatar/01.webp"} />
                                <Heading as="h4">{"Iftakhar Alam"}</Heading>
                                <Text as="p">test@gmail.com</Text>
                            </Col>
                            <Col xl={12}>
                                <CardLayout>
                                    <Row>
                                        <Col xl={12}><Alert show={errorMsgShow} onClose={() => handleStateValue("errorMsgShow",false)} variant="danger" dismissible>Provided input is not valid.</Alert></Col>
                                        <Col xl={12}>
                                            <LabelField
                                                label="Disposition"
                                                placeholder="Select Disposition"
                                                valueKey="name"
                                                optionKey="key"
                                                option={[{ name: "Option One", key: "op1" }, { name: "Option Two", key: "op2" }]}
                                                fieldSize="w-100 h-md"
                                                onChange={(value) => { handleStateValue("disposition",value) }}
                                            />
                                        </Col>
                                        <Col xl={12}><LabelTextarea onChange={(value) => {  handleStateValue("replyDisText",value) }} label="Disposition Message" fieldSize="w-100 h-text-md" /></Col>
                                    </Row>
                                </CardLayout>
                            </Col>
                        </Row>
                        <Modal.Footer>
                            <Button type="button" onClick={()=>{sendCustomerDispositionReply()}} className="btn btn-success">Disposition Reply</Button>
                        </Modal.Footer>
                    </Box>
                </Modal.Body>
            </Modal>
        </>
    )
}
