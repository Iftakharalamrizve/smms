import React from "react";

export default function Input({ type, placeholder, className,value, onChange, ...rest }) {
    return <input onChange={(e) => onChange(e.target.value)} type={ type || "text" }  value={value} placeholder={ placeholder } className={ className } { ...rest } />
}