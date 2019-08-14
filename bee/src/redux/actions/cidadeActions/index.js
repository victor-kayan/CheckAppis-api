import {
  GET_ALL_CIDADES_BY_UF,
  LOADING_CIDADE,
  RESET_CIDADES_LIST
} from "./actionsTypes";
import Api from "../../../services/api";
import { uris } from "../../../assets";

export const getCidadesByUf = uf => {
  console.log("===========================");
  console.log("      GET_ALL_CIDADE_BY_UF ");
  console.log("===========================");

  return dispatch => {
    dispatch({
      type: LOADING_CIDADE,
      payload: {
        loadingCidade: true
      }
    });

    Api.get(uris.GET_ALL_CIDADES_BY_UF + uf)
      .then(response => {
        console.log(response.data);
        dispatch({
          type: GET_ALL_CIDADES_BY_UF,
          payload: {
            list_cidades: response.data.cidades,
            loadingCidade: false
          }
        });
      })
      .catch(error => {
        dispatch({
          type: LOADING_CIDADE,
          payload: {
            loadingCidade: false
          }
        });
      });
  };
};

export const resetListCidades = () => {
  return dispatch => {
    dispatch({
      type: RESET_CIDADES_LIST,
      payload: {}
    });
  };
};
