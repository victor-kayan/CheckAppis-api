import { LOADING_COLMEIA, GET_ALL_COLMEIAS, REQUEST_COLMEIA_ERROR } from "../../actions/colmeiasByApiarioActions/actionsTypes";

const initialState = {
  colmeias: [],
  loadingColmeia: false,
  code: ''
};
export const ColmeiaReducer = (state = initialState, action) => {
  switch (action.type) {
    case GET_ALL_COLMEIAS:
      return {
        ...state,
        colmeias: action.payload.colmeias,
        loadingColmeia: action.payload.loadingColmeia,
        code: action.payload.code,
      };
    case LOADING_COLMEIA:
      return {
        ...state,
        loadingColmeia: action.payload.loadingColmeia,
        code: action.payload.code,
      };
      case REQUEST_COLMEIA_ERROR:
      return {
        ...state,
        loadingColmeia: action.payload.loadingColmeia,
        code: action.payload.code,
      };
    default:
      return state;
  }
};
