import { Button, Col, Row } from "antd";
import React, { useContext } from "react";
import MultiStepFormContext from "@/Components/MultiStepFormContext";

const Review = () => {
  const { type, address, next, prev } = useContext(MultiStepFormContext);
  return (
    <div className={"details__wrapper"}>
      <Row>
        <Col span={24}>
          <h1>Details</h1>
          <p>Name: {type.name}</p>
          <p>Age: {type.age}</p>
          <p>Profession: {details.profession}</p>
        </Col>
        <Col span={24}>
          <h1>Address</h1>
          <p>Address-1: {address.address1}</p>
          {address.address2 && <p>Address-2: {address.address2}</p>}
          <p>City: {address.city}</p>
          <div
            className={
              "form__item button__items d-flex justify-content-between"
            }
          >
            <Button type={"default"} onClick={prev}>
              Back
            </Button>
            <Button type={"primary"} onClick={next}>
              Confirm
            </Button>
          </div>
        </Col>
      </Row>
    </div>
  );
};
export default Review;
