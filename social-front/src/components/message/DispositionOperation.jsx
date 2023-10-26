import React,{useState} from 'react'
import MModal from '../modals/MModal';
import { Modal, Form, Row, Col, Alert } from "react-bootstrap";
import { Option, Heading, Box, Anchor, Button, Image, Input, Label, Icon, Text } from "../../components/elements";
import { LabelField, LabelTextarea } from "../../components/fields";
import { CardLayout, CardHeader } from "../../components/cards";
import { messageReply } from "@store/actions/fbMessageAction";
import { useDispatch } from 'react-redux';



export default function DispositionOperation({onModalChange , modalStatus, sessionId, pageId}) {
  const [replyText, setAgentReplyText] = useState("");
  const [disposition, setDisposition] = useState("");
  const [show, setErrorMessage] = useState(false);
  const dispatch = useDispatch();

  const sendCustomerDispositionReply = () => {
    console.log(replyText,disposition)
    if(replyText && disposition){
      let messageData = {
        disposition_id: disposition,
        session_id:sessionId,
        page_id: pageId,
        reply: replyText
      }
      dispatch(messageReply(messageData));
      setAgentReplyText("");
      setDisposition("");
    }else{
      setErrorMessage(true);
    }
  }

  return (
    <MModal onModalChange={onModalChange} modalStatus ={modalStatus} title={"Message Disposition"}>
      <Box className="">
          <Row>
              <Col md={{ span: 4, offset: 4 }}>
                  <Image src={"http://localhost:3000/images/avatar/01.webp"}  />
                  <Heading as="h4">{ "Iftakhar Alam" }</Heading>
                  <Text as="p">test@gmail.com</Text>
              </Col>
              <Col xl={12}>
                  <CardLayout>
                      <Row>
                          <Col xl={12}><Alert show={show} onClose={() => setErrorMessage(false)}  variant="danger" dismissible>Provided input is not valid.</Alert></Col>
                          <Col xl={12}>
                            <LabelField 
                              label="Disposition" 
                              placeholder ="Select Disposition"
                              valueKey="name" 
                              optionKey="key"  
                              option={[{name:"Option One",key:"op1"},{name:"Option Two",key:"op2"}]} 
                              fieldSize="w-100 h-md" 
                              onChange={(value)=>{setDisposition(value)}}
                            />
                          </Col>
                          <Col xl={12}><LabelTextarea  onChange={(value)=>{setAgentReplyText(value)}} label="Disposition Message" fieldSize="w-100 h-text-md" /></Col>
                      </Row>
                  </CardLayout>
              </Col>
          </Row>
          <Modal.Footer>
              <Button type="button" onClick={() => sendCustomerDispositionReply()} className="btn btn-success">Disposition Reply</Button>
          </Modal.Footer>
      </Box>
    </MModal>
  )
}
