import { LOADING_PERFIL, GET_PERFIL, UPDATE_PERFIL } from "./actionsTypes";
import Api from "../../../services/api";
import { uris } from "../../../assets";

export const getPerfil = () => {
  return dispatch => {
    dispatch({
      type: LOADING_PERFIL,
      payload: {
        loadingPerfil: true
      }
    });

    Api.get(uris.GET_PERFIL)
      .then(response => {
        dispatch({
          type: GET_PERFIL,
          payload: {
            userPerfil: response.data.user,
            loadingPerfil: false
          }
        });
      })
      .catch(error => {
        dispatch({
          type: LOADING_PERFIL,
          payload: {
            loadingPerfil: false
          }
        });
      });
  };
};

export const updatePerfil = ({ request }) => {
  return dispatch => {
    dispatch({
      type: LOADING_PERFIL,
      payload: {
        loadingUpdatePerfil: true
      }
    });

    Api.put(uris.UPDATE_PERFIL, request)
      .then(response => {
        dispatch({
          type: UPDATE_PERFIL,
          payload: {
            userPerfil: response.data.user,
            loadingUpdatePerfil: false,
            messagePerfil: response.data.message,
            code: response.status
          }
        });
        dispatch(getPerfil());
      })
      .catch(error => {
        dispatch({
          type: LOADING_PERFIL,
          payload: {
            loadingUpdatePerfil: false,
            messagePerfil:
              (error.response && error.response.data.message) ||
              "Houve algum erro no servidor",
            code: (error.response && error.response.status) || 500
          }
        });
      });
  };
};
