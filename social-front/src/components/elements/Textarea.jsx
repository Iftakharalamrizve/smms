import React from "react";

export default function Textarea({onChange,  type, placeholder, className, children }) {
    return <textarea onChange={(e)=>onChange(e.target.value)} type={ type || "text" } placeholder={ placeholder } className={ className }>{ children }</textarea>
}