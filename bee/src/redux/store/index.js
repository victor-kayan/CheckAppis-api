import { createStore, applyMiddleware } from "redux";
import { Reducers } from "../reducers";
import thunk from "redux-thunk";
import LogMiddleware from "./LogMiddleware";

export const Store = createStore(
  Reducers,
  applyMiddleware(thunk, ...LogMiddleware)
);
