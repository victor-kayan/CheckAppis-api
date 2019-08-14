import {
  GET_ALL_APIARIOS,
  LOADING_APIARIO,
  SAVE_APIARIO,
  SAVE_APIARIO_ERROR,
  DETALHES_APIARIO,
  DELETE_APIARIO,
  UPDATE_APIARIO
} from "./actionsTypes";
import Api from "../../../services/api";
import { uris } from "../../../assets";

export const getAllapiarios = () => {
  return dispatch => {
    dispatch({
      type: LOADING_APIARIO,
      payload: {
        loadingApiario: true
      }
    });

    Api.get(uris.GET_ALL_APIARIOS)
      .then(response => {
        dispatch({
          type: GET_ALL_APIARIOS,
          payload: {
            listApiarios: response.data.apiarios,
            loaloadingApiarioding: false
          }
        });
      })
      .catch(error => {
        dispatch({
          type: LOADING_APIARIO,
          payload: {
            loadingApiario: false,
            messageApiario:
              (error.response && error.response.data.message) ||
              "Houve alguma falha, aguarde",
            code: (error.response && error.response.status) || 500
          }
        });
      });
  };
};

export const saveApiario = request => {
  return dispatch => {
    dispatch({
      type: LOADING_APIARIO,
      payload: {
        loadingApiario: true
      }
    });

    Api.post(uris.SAVE_APIARIO, request)
      .then(response => {
        dispatch({
          type: SAVE_APIARIO,
          payload: {
            loadingApiario: false,
            code: response.status,
            messageApiario: response.data.message
          }
        });
        dispatch(getAllapiarios());
      })
      .catch(error => {
        dispatch({
          type: SAVE_APIARIO_ERROR,
          payload: {
            loadingApiario: false,
            code: (error.response && error.response.status) || 500,
            messageApiario:
              (error.response && error.response.data.message) || ""
          }
        });
      });
  };
};

export const detalhesApiario = id => {
  return dispatch => {
    dispatch({
      type: LOADING_APIARIO,
      payload: {
        loadingApiario: true
      }
    });

    Api.get(uris.DETALHES_APIARIO + id)
      .then(response => {
        dispatch({
          type: DETALHES_APIARIO,
          payload: {
            loadingApiario: false,
            apiarioDetalhes: response.data.apiario,
            messageApiario: response.data.message
          }
        });
      })
      .catch(error => {
        dispatch({
          type: LOADING_APIARIO,
          payload: {
            loadingApiario: false,
            code: (error.response && error.response.status) || 500,
            messageApiario:
              (error.response && error.response.data.message) ||
              "Hou algum problema, apor favor aguarde"
          }
        });
      });
  };
};

export const deleteApiario = id => {
  return dispatch => {
    dispatch({
      type: LOADING_APIARIO,
      payload: {
        loadingApiario: true
      }
    });

    Api.delete(uris.DELETE_APIARIO + id)
      .then(response => {
        dispatch({
          type: DELETE_APIARIO,
          payload: {
            loadingApiario: false,
            messageApiario: response.data.message,
            code: response.status
          }
        });
        dispatch(getAllapiarios());
      })
      .catch(error => {
        dispatch({
          type: LOADING_APIARIO,
          payload: {
            loadingApiario: false,
            code: (error.response && error.response.status) || 500,
            messageApiario:
              (error.response && error.response.data.message) ||
              "Houve algum problema, por favor aguarde"
          }
        });
      });
  };
};


export const updateApiario = ({ id, request }) => {
  return dispatch => {
    dispatch({
      type: LOADING_APIARIO,
      payload: {
        loadingApiario: true
      }
    });

    Api.put(uris.UPDATE_APIARIO + id, request)
      .then(response => {
        dispatch({
          type: UPDATE_APIARIO,
          payload: {
            loadingApiario: false,
            code: response.status,
            messageApiario: response.data.message
          }
        });
        dispatch(getAllapiarios());
      })
      .catch(error => {
        dispatch({
          type: SAVE_APIARIO_ERROR,
          payload: {
            loadingApiario: false,
            code: (error.response && error.response.status) || 500,
            messageApiario:
              (error.response && error.response.data.message) || ""
          }
        });
      });
  };
};


