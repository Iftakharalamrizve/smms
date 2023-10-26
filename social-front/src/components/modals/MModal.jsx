import { useState } from 'react';
import Modal from 'react-bootstrap/Modal';
export default function MModal({onModalChange, modalStatus, title, children }) {
  return (
    <>
      <Modal
        show={modalStatus}
        onHide={()=>{onModalChange(false)}}
        dialogClassName="modal-45w"
        aria-labelledby="example-modal-sizes-title-sm"
      >
       <Modal.Header closeButton>
          <Modal.Title id="example-modal-sizes-title-sm">
            {title}
          </Modal.Title>
        </Modal.Header>
        <Modal.Body>
          {children}
        </Modal.Body>
      </Modal>
    </>
  );
}
