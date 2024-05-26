import React, { useEffect, useRef } from "react";
import Draggable from "react-draggable";

const Dragtest = () => {

  const windowWidth = window.innerWidth;
  const windowHeight = window.innerHeight;

  return (
      <>
          Dragtest
          <Draggable>
              <div>ドラッグ可能なコンテンツ</div>
          </Draggable>
          <Draggable
              axis="x" // x軸のみドラッグ可能
              handle=".handle" // ドラッグハンドルの要素
              defaultPosition={{ x: 0, y: 0 }} // 初期位置
              grid={[25, 25]} // ドラッグ時のグリッドサイズ
              // onStart={this.handleStart} // ドラッグ開始時のイベントハンドラ
              // onDrag={this.handleDrag} // ドラッグ中のイベントハンドラ
              // onStop={this.handleStop} // ドラッグ終了時のイベントハンドラ
          >
              <div>
                  <div className="handle">ここからドラッグ</div>
                  <div>ドラッグ可能なコンテンツ</div>
              </div>
          </Draggable>
          <div style={{ width:"200px",height:"100px" }}>

          <Draggable
              
              bounds={{
                  left: 0,
                  top: 0,
                  right: windowWidth - 100,
                  bottom: windowHeight - 400,
              }}
          >
              <div>ドラッグ可能なコンテンツ</div>
          </Draggable>
          </div>
      </>
  );
};

export default Dragtest;
