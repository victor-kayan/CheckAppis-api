import {
  GET_ALL_APICULTORES,
  SAVE_APICULTOR,
  LOADING_APICULTOR,
  DELETE_APICULTOR,
  UPDATE_APICULTOR,
  UPDATE_APICULTOR_ERROR,
  GET_APICULTOR,
  SAVE_APICULTOR_ERROR
} from "../../actions/apicultorActions/actionsTypes";

const initialState = {
  list_apicultor: [],
  apicultor: null,
  loading: false,
  logged: false,
  code: null,
  message_apicultor: null
};
export const ApicultorReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_ALL_APICULTORES:
      return {
        ...state,
        list_apicultor: action.payload.list_apicultor,
        loading: action.payload.loading,
        code: action.payload.code
      };

    case SAVE_APICULTOR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        message_apicultor: action.payload.message_apicultor
      };
    case SAVE_APICULTOR_ERROR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        message_apicultor: action.payload.message_apicultor
      };
    case UPDATE_APICULTOR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        message_apicultor: action.payload.message_apicultor
      };
    case UPDATE_APICULTOR_ERROR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        message_apicultor: action.payload.message_apicultor
      };
    case GET_APICULTOR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        apicultor: action.payload.apicultor
      };
    case DELETE_APICULTOR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        message_apicultor: action.payload.message_apicultor
      };
    case LOADING_APICULTOR:
      return {
        ...state,
        loading: action.payload.loading,
        code: action.payload.code,
        message_apicultor: action.payload.message_apicultor
      };

    default:
      return state;
  }
};
