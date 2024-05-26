import React, { useEffect, useState, useCallback } from "react";

const Mausetest = () => {
    const [cursorPos, setCursorPos] = useState({ x: 0, y: 0 });
    const [constrainedArea, setConstrainedArea] = useState({
        left: 0,
        top: 0,
        right: 0,
        bottom: 0,
    });

    const handleMouseMove = useCallback(
        (e) => {
            const { left, top, right, bottom } = constrainedArea;
            const x = Math.max(left, Math.min(e.clientX, right - 20));
            const y = Math.max(top, Math.min(e.clientY, bottom - 20));
            setCursorPos({ x, y });
        },
        [constrainedArea]
    );

    useEffect(() => {
        const element = document.getElementById("constrained-area");
        if (element) {
            const rect = element.getBoundingClientRect();
            setConstrainedArea({
                left: rect.left,
                top: rect.top,
                right: rect.right,
                bottom: rect.bottom,
            });
        }
    }, []);

    useEffect(() => {
        window.addEventListener("mousemove", handleMouseMove);
        return () => window.removeEventListener("mousemove", handleMouseMove);
    }, [handleMouseMove]);

    return (
        <div>
            <div
                id="constrained-area"
                style={{
                    width: "500px",
                    height: "300px",
                    border: "1px solid black",
                    position: "relative",
                }}
            >
                <div
                    style={{
                        width: "20px",
                        height: "20px",
                        backgroundColor: "red",
                        position: "absolute",
                        left: cursorPos.x,
                        top: cursorPos.y,
                        borderRadius: "50%",
                        pointerEvents: "none",
                    }}
                />
            </div>
        </div>
    );
};

export default Mausetest;
