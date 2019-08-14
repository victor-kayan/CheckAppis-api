import axios from "axios";
import uris from "../assets/uris";

const Api = axios.create({
  baseURL: uris.BASE_URL
});

Api.defaults.headers.common["Authorization"] = `Bearer ${localStorage.getItem(
  "token"
)}`;

// Api.interceptors.response.use(
//   function(response) {
//     return response;
//   },
//   function(error) {
//     const token = localStorage.getItem("token");
//     if (401 === error.response.status && token  !== null) {
//       console.log("Token inválido");
//       console.log('Token: ', token)
//       if (token !== null) {
//         window.location = "/login";
//       }
//     }
//   }
// );

// Api.interceptors.response.use(function (response) {
//   return response;
// }, function (error) {
//   // notification.open({
//   //   message: "Verifique sua conexão",
//   //   description:':)',
//   //   icon: <Icon type={"smile"} style={{ color: "#108ee9" }} />
//   // });
//   window.location = '/login'
// });

// Api.interceptors.request.use(function(config) {
//     const token = localStorage.getItem('token');
//     if(token) {
//         config.headers.Authorization = 'Bearer ${token}';
//         console.log(config);
//         return config;
//     } else {
//         console.log('There is not token yet...');
//         return config;
//     }
// }, function(err) {
//     return Promise.reject(err);
// });

export default Api;
