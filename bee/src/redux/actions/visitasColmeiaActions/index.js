import {
  GET_ALL_VISITAS_COLMEIA,
  LOADING_VISITA_COLMEIA,
  REQUEST_VISITA_ERROR,
  SAVE_INTERVENCAO_COLMEIA,
  DELETE_VISITA_COLMEIA
} from "./actionsTypes";
import Api from "../../../services/api";
import { uris } from "../../../assets";

export const saveIntervencaoColmeia = ({
  descricao,
  colmeia_id,
  data_inicio,
  data_fim
}) => {
  return dispatch => {
    dispatch({
      type: LOADING_VISITA_COLMEIA,
      payload: {
        loadingVisita: true
      }
    });

    Api.post(uris.SAVE_INTERVENCAO_COLMEIA, {
      descricao,
      colmeia_id,
      data_inicio,
      data_fim
    })
      .then(response => {
        dispatch({
          type: SAVE_INTERVENCAO_COLMEIA,
          payload: {
            loadingVisita: false,
            code: response.status,
            messageVisita: response.data.message
          }
        });
        dispatch(getAllColmeiasVisitas());
      })
      .catch(error => {
        dispatch({
          type: REQUEST_VISITA_ERROR,
          payload: {
            loadingVisita: false,
            code: (error.response && error.response.status) || 500,
            messageVisita: (error.response && error.response.data.message) || ""
          }
        });
      });
  };
};

export const getAllColmeiasVisitas = () => {
  return dispatch => {
    dispatch({
      type: LOADING_VISITA_COLMEIA,
      payload: {
        loadingVisita: true
      }
    });

    Api.get(uris.GET_ALL_VISITAS_COLMEIA)
      .then(response => {
        dispatch({
          type: GET_ALL_VISITAS_COLMEIA,
          payload: {
            visitasColmeias: response.data,
            loadingVisita: false,
            code: response.status
          }
        });
      })
      .catch(error => {
        dispatch({
          type: REQUEST_VISITA_ERROR,
          payload: {
            loadingVisita: false,
            code: (error.response && error.response.status) || 500
          }
        });
      });
  };
};

export const deleteVisitaColmeia = id => {
  return dispatch => {
    dispatch({
      type: LOADING_VISITA_COLMEIA,
      payload: {
        loadingVisita: true
      }
    });

    Api.delete(uris.DELETE_VISITA_COLMEIA + id)
      .then(response => {
        dispatch({
          type: DELETE_VISITA_COLMEIA,
          payload: {
            loadingVisita: false,
            code: response.status
          }
        });
        dispatch(getAllColmeiasVisitas());
      })
      .catch(error => {
        dispatch({
          type: REQUEST_VISITA_ERROR,
          payload: {
            loadingVisita: false,
            code: (error.response && error.response.status) || 500
          }
        });
      });
  };
};
