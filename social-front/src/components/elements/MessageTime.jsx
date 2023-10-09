import React from "react";

export default function MessageTime({ time }) {
    const calculateTimeAgo = (dateString) => {
        const currentDate = new Date();
        const pastDate = new Date(dateString);
        const timeDifference = currentDate - pastDate;

        // Convert milliseconds to minutes and hours
        const minutesAgo = Math.floor(timeDifference / 60000);
        const hoursAgo = Math.floor(minutesAgo / 60);

        if (hoursAgo > 0) {
            if (hoursAgo === 1) {
            return '1 Hour ago';
            } else {
            return `${hoursAgo} Hours ago`;
            }
        } else {
            if (minutesAgo === 1) {
            return '1 Minute ago';
            } else {
            return `${minutesAgo} Minutes ago`;
            }
        }
    };
    return <>{calculateTimeAgo(time)}</>
}