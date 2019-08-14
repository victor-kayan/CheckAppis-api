const uris = {
  DOMINIO: "http://192.168.200.237",
  BASE_URL: "http://192.168.200.237/api/",

  LOGIN: "auth/login/tecnico",
  LOGIN_FACEBOOK: "auth/login/tecnico/facebook",
  LOGOUT: "auth/logout",

  SAVE_APICULTOR: "auth/registro",
  SAVE_APIARIO: "apiario",
  SAVE_INTERVENCAO_APIARIO: "intervencao/apiario",
  SAVE_INTERVENCAO_COLMEIA: "intervencao/colmeia",

  APICULTOR: "user",

  UPDATE_PERFIL: "tecnico/perfil",
  UPDATE_APICULTOR: "user/",
  UPDATE_APIARIO: "apiario/",

  DELETE_APICULTOR: "user/",
  DELETE_APIARIO: "apiario/",
  DELETE_VISITA_APIARIO: "apiario/visitas/",
  DELETE_INTERVENCAO_APIARIO: "intervencao/apiario/",
  DELETE_INTERVENCAO_COLMEIA: "intervencao/colmeia/",

  DETALHES_APIARIO: "apiario/",

  GET_PERFIL: "tecnico/perfil",
  GET_ALL_APICULTORES: "apicultores",
  GET_ALL_APIARIOS: "apiario",
  GET_APICULTOR: "user/",
  GET_CIDADES_UF: "cidades/uf/",
  GET_ALL_INFO_HOME: "home",
  GET_ALL_CIDADES_BY_UF: "cidades/uf/",
  GET_ALL_VISITAS_APIARIO: "apiarios/visitas",
  GET_ALL_VISITAS_COLMEIA: "apiarios/visitas-colmeias",
  GET_ALL_INTERVENCOES_APIARIO: "intervencao/apiario",
  GET_ALL_INTERVENCOES_COLMEIA: "intervencao/colmeia",
  GET_ALL_COLMEIAS: "colmeias-por-apiario/",

  GOOGLE_MAPS_URI:
    "https://maps.googleapis.com/maps/api/js?key=AIzaSyA3byNpUcao4ZQud-zGppXCjHSZVOaoygI&v=3.exp&libraries=geometry,drawing,places",

  GOOGLE_MAPS_GEOCODE_URL:
    "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyA3byNpUcao4ZQud-zGppXCjHSZVOaoygI&address="
};

export default uris;
