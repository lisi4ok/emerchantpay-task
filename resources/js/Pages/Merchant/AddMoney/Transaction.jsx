import React, { useContext } from "react";
import { Formik } from "formik";
import { Button } from "antd";
import { Input } from "formik-antd";
import MultiStepFormContext from "@/Components/MultiStepFormContext";
const Transaction = () => {
  const { transaction, setTransaction, next, prev } = useContext(MultiStepFormContext);
  return (
    <Formik
      initialValues={transaction}
      onSubmit={(values) => {
        setTransaction(values);
        next();
      }}
      validate={(values) => {
        const errors = {};
        if (!values.user_id) errors.user_id = "User is Required";
        if (!values.amount) errors.amount = "Amount is required";
        return errors;
      }}
    >
      {({ handleSubmit, errors }) => {
        return (
          <div className={"details__wrapper"}>
            <div className={`form__item ${errors.user_id && "input__error"}`}>
              <label>User *</label>
              <Input name={"user_id"} />
              <p className={"error__feedback"}>{errors.user_id}</p>
            </div>
            <div className={`form__item ${errors.amount && "input__error"}`}>
              <label>Amount *</label>
              <Input name={"amount"} />
              <p className={"error__feedback"}>{errors.amount}</p>
            </div>
            <div
              className={
                "form__item button__items d-flex justify-content-between"
              }
            >
              <Button type={"default"} onClick={prev}>
                Back
              </Button>
              <Button type={"primary"} onClick={handleSubmit}>
                Next
              </Button>
            </div>
          </div>
        );
      }}
    </Formik>
  );
};
export default Transaction;
