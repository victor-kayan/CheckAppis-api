import {
  REQUEST_INTERVENCAO_ERROR,
  GET_ALL_INTERVENCOES_COLMEIA,
  DELETE_INTERVENCAO_COLMEIA,
  LOADING_INTERVENCAO_COLMEIA
} from "../../actions/intervencoesColmeiaActions/actionsTypes";

const initialState = {
  loadingIntervencao: false,
  intervencoesColmeias: {},
  messageIntervencao: "",
  code: null
};
export const IntervencaoColmeiaReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_ALL_INTERVENCOES_COLMEIA:
      return {
        ...state,
        intervencoesColmeias: action.payload.intervencoesColmeias,
        loadingIntervencao: action.payload.loadingIntervencao,
        code: action.payload.code
      };
    case DELETE_INTERVENCAO_COLMEIA:
      return {
        ...state,
        loadingIntervencao: action.payload.loadingIntervencao,
        code: action.payload.code
      };
    case LOADING_INTERVENCAO_COLMEIA:
      return {
        ...state,
        loadingIntervencao: action.payload.loadingIntervencao
      };
    case REQUEST_INTERVENCAO_ERROR:
      return {
        ...state,
        loadingIntervencao: action.payload.loadingIntervencao,
        code: action.payload.code,
        messageIntervencao: action.payload.messageIntervencao
      };
    default:
      return state;
  }
};
