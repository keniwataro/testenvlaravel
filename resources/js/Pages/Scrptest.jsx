import React from "react";

const Scrptest = ({html}) => {
  console.log(html);
  
  return (
      <div>
          {html.map((ht, index) => (
              <div key={index}>{ht}</div>
          ))}
      </div>
  );
};

export default Scrptest;
