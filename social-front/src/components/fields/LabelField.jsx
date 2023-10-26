import React from "react";
import { Box, Input, Label, Select, Option } from "../elements";

export default function LabelField({ onChange, label, labelDir, fieldSize, option, type, placeholder, valueKey, optionKey, ...rest }) {
    return (
        <Box className={`mc-label-field-group ${ label ? labelDir || "label-col" : "" }`}>
            {label && <Label className="mc-label-field-title">{ label }</Label>}
            {type ? 
                <Input 
                    type = { type || "text" } 
                    onChange = {(e)=>{console.log(e.target)}}
                    placeholder = { placeholder || "Type here..." } 
                    className = {`mc-label-field-input ${ fieldSize || "w-md h-sm" }`} 
                    { ...rest } 
                />
            :
                <Select onChange = {(e)=>{onChange(e.target.value)}} className={`mc-label-field-select ${ fieldSize || "w-md h-sm" }`} { ...rest }>
                    <Option  value=""> {placeholder} </Option>
                    {option.map((item, index) => (
                        <Option key={ index } value={ item[optionKey] }>{ item[valueKey]}</Option>
                    ))}
                </Select>
            }
        </Box>
    )
}