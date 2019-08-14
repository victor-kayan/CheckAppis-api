import {
  GET_ALL_APIARIOS,
  LOADING_APIARIO,
  SAVE_APIARIO,
  SAVE_APIARIO_ERROR,
  DETALHES_APIARIO,
  DELETE_APIARIO,
  UPDATE_APIARIO
} from "../../actions/apiarioActions/actionsTypes";

const initialState = {
  listApiarios: [],
  apiario: {},
  apiarioDetalhes: {},
  loadingApiario: false,
  code: null,
  cidades: null,
  messageApiario: null
};
export const ApiarioReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_ALL_APIARIOS:
      return {
        ...state,
        listApiarios: action.payload.listApiarios,
        loadingApiario: action.payload.loadingApiario
      };
    case DETALHES_APIARIO:
      return {
        ...state,
        apiarioDetalhes: action.payload.apiarioDetalhes,
        loadingApiario: action.payload.loadingApiario,
        messageApiario: action.payload.messageApiario
      };
    case SAVE_APIARIO:
      return {
        ...state,
        apiario: action.payload.apiario,
        loadingApiario: action.payload.loadingApiario,
        code: action.payload.code,
        messageApiario: action.payload.messageApiario
      };
    case UPDATE_APIARIO:
      return {
        ...state,
        apiario: action.payload.apiario,
        loadingApiario: action.payload.loadingApiario,
        code: action.payload.code,
        messageApiario: action.payload.messageApiario
      };
    case SAVE_APIARIO_ERROR:
      return {
        ...state,
        loadingApiario: action.payload.loadingApiario,
        code: action.payload.code,
        messageApiario: action.payload.messageApiario
      };
    case DELETE_APIARIO:
      return {
        ...state,
        loadingApiario: action.payload.loadingApiario,
        code: action.payload.code,
        messageApiario: action.payload.messageApiario
      };
    case LOADING_APIARIO:
      return {
        ...state,
        loadingApiario: action.payload.loadingApiario,
        code: action.payload.code,
        messageApiario: action.payload.messageApiario
      };

    default:
      return state;
  }
};
