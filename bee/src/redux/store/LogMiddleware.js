const LogMiddleware = ({ dispatch, getState }) => next => action => {
  const state = getState();

  if (process.env.NODE_ENV === "development") {
    console.log("====================================");
    console.log("0 - STATE: ", state);
    console.log("1 - ACTION", action);
    console.log("====================================");
  }

  return next(action);
};

export default [LogMiddleware];
