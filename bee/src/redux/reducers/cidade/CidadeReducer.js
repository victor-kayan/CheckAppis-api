import {
  GET_ALL_CIDADES_BY_UF,
  LOADING_CIDADE,
  RESET_CIDADES_LIST
} from "../../actions/cidadeActions/actionsTypes";

const initialState = {
  list_cidades: [],
  loadingCidade: false,
  message: ""
};
export const CidadeReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_ALL_CIDADES_BY_UF:
      return {
        ...state,
        list_cidades: action.payload.list_cidades,
        loadingCidade: action.payload.loadingCidade,
        message: action.payload.message
      };

    case LOADING_CIDADE:
      return {
        ...state,
        loadingCidade: action.payload.loadingCidade,
        message: action.payload.message
      };

    case RESET_CIDADES_LIST:
      return {
        ...state,
        list_cidades: []
      };

    default:
      return state;
  }
};
