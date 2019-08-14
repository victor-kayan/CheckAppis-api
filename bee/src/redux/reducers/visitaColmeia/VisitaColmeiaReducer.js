import {
  GET_ALL_VISITAS_COLMEIA,
  LOADING_VISITA_COLMEIA,
  REQUEST_VISITA_ERROR,
  SAVE_INTERVENCAO_COLMEIA,
  DELETE_VISITA_COLMEIA
} from "../../actions/visitasColmeiaActions/actionsTypes";

const initialState = {
  loadingVisita: false,
  visitasColmeias: {},
  messageVisita: "",
  code: null
};
export const VisitaColmeiaReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_ALL_VISITAS_COLMEIA:
      return {
        ...state,
        visitasColmeias: action.payload.visitasColmeias,
        loadingVisita: action.payload.loadingVisita,
        code: action.payload.code
      };
    case SAVE_INTERVENCAO_COLMEIA:
      return {
        ...state,
        loadingVisita: action.payload.loadingVisita,
        code: action.payload.code,
        messageVisita: action.payload.messageVisita
      };
    case DELETE_VISITA_COLMEIA:
      return {
        ...state,
        loadingVisita: action.payload.loadingVisita,
        code: action.payload.code,
      };
    case LOADING_VISITA_COLMEIA:
      return {
        ...state,
        loadingVisita: action.payload.loadingVisita
      };
    case REQUEST_VISITA_ERROR:
      return {
        ...state,
        loadingVisita: action.payload.loadingVisita,
        code: action.payload.code,
        messageVisita: action.payload.messageVisita
      };
    default:
      return state;
  }
};
