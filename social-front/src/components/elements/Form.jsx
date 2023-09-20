import React from "react";

export default function Form({ onSubmit, children, className }) {
    return <form onSubmit={onSubmit} className={ className }>{ children }</form>
}