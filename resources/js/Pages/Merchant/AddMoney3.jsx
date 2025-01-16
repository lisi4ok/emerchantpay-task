import React, { useState } from "react";
import { Steps } from "antd";
import { Provider } from "@/Components/MultiStepFormContext";
import Type from "./AddMoney/Type";
import Transaction from "./AddMoney/Transaction";
import Review from "./AddMoney/Review";
import InputError from "@/Components/InputError";
import InputLabel from "@/Components/InputLabel";
import TextInput from "@/Components/TextInput";
import SelectInput from "@/Components/SelectInput";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Head, Link, useForm } from "@inertiajs/react";
import TextAreaInput from "@/Components/TextAreaInput";
import Checkbox from "@/Components/Checkbox";

const { Step } = Steps;

const typeInitialState = {
  type: "",
};

const transactionInitialState = {
  user: "",
  amount: 0,
};

const renderStep = (step) => {
  switch (step) {
    case 0:
      return <Type />;
    case 1:
      return <Transaction />;
    case 2:
      return <Review />;
    default:
      return null;
  }
};
export default function AddMoney({ auth, users }) {
  const [type, setType] = useState(typeInitialState);
  const [transaction, setTransaction] = useState(transactionInitialState);
  const [currentStep, setCurrentStep] = useState(0);
  const { data, setData, post, errors, reset } = useForm({
    type: "",
    user_id: "",
    amount: "",
  });


  const next = () => {
    if (currentStep === 2) {
      setCurrentStep(0);
      setType(typeInitialState);
      setTransaction(transactionInitialState);
      return;
    }
    setCurrentStep(currentStep + 1);
  };
  const prev = () => setCurrentStep(currentStep - 1);
  return (
    <Provider value={{ type, setType, next, prev, transaction, setTransaction }}>
      <Steps current={currentStep}>
        <Step title={"Choose How to add Money"} />
        <Step title={"Set amount and choose User"} />
        <Step title={"Review and Commit"} />
      </Steps>
      <div>{renderStep(currentStep)}</div>
    </Provider>
  );
};
