import React, { Component } from "react";

import HeaderBee from "../../componentes/HeaderBee";
import FooterBee from "../../componentes/FooterBee";
import SidebarBee from "../../componentes/SidebarBee";
import { Switch, Route } from "react-router-dom";
import { Layout } from "antd";
import ListApicultor from "./subpages/Apicultor/Lista";
import TecnicoPerfil from "./subpages/Tecnico/Perfil";
import ListApiario from "./subpages/Apiarios";
import Home from "./subpages/Home";
import RelatorioApiario from "./subpages/Relatorios/Apiarios";
import RelatorioVisitas from "./subpages/Relatorios/Visitas";
import RelatorioIntervencao from "./subpages/Relatorios/Intervencoes";
import VisitaApiario from "./subpages/VisitaApiario";
import VisitaColmeia from "./subpages/VisitaColmeia";
import IntervencaoApiario from "./subpages/IntervencaoApiario";
import IntervencaoColmeia from "./subpages/IntervencaoColmeia";

class Dashboard extends Component {
  render() {
    return (
      <Layout style={{ minHeight: "100vh" }}>
        {/* INIT SIDEBAR */}
        <SidebarBee />
        {/* END SIDEBAR */}

        <Layout>
          {/* INIT HEADER */}
          <HeaderBee history={this.props.history} />
          {/* END HEADER */}

          {/* INIT CONTENT */}
          <main>
            <Switch>
              <Route
                exact
                path="/apiarios/list"
                component={ListApiario}
                history={this.props.history}
              />
              <Route
                exact
                path="/apiarios/relatorios"
                component={RelatorioApiario}
                history={this.props.history}
              />
              <Route
                exact
                path="/visitas/relatorios"
                component={RelatorioVisitas}
                history={this.props.history}
              />
              <Route
                exact
                path="/intervencoes/relatorios"
                component={RelatorioIntervencao}
                history={this.props.history}
              />

              <Route
                exact
                path="/intervencoes/apiarios"
                component={IntervencaoApiario}
                history={this.props.history}
              />

              <Route
                exact
                path="/intervencoes/colmeias"
                component={IntervencaoColmeia}
                history={this.props.history}
              />

              <Route
                exact
                path="/apicultores/list"
                component={ListApicultor}
                history={this.props.history}
              />
              <Route
                exact
                path="/tecnico/perfil"
                component={TecnicoPerfil}
                history={this.props.history}
              />

              <Route
                exact
                path="/apiarios/visitas"
                component={VisitaApiario}
                history={this.props.history}
              />

              <Route
                exact
                path="/colmeias/visitas"
                component={VisitaColmeia}
                history={this.props.history}
              />

              <Route
                exact
                path="/dashboard"
                component={Home}
                history={this.props.history}
              />
              <Route
                exact
                path="/home"
                component={Home}
                history={this.props.history}
              />
              <Route
                exact
                path="/"
                component={Home}
                history={this.props.history}
              />

              <Route path="/" component={Home} history={this.props.history} />
            </Switch>
          </main>
          {/* END CONTENT */}

          {/* <ContentBee/> */}

          {/* INIT FOOTER */}
          <FooterBee />
          {/* END FOOTER */}
        </Layout>
      </Layout>
    );
  }
}

export default Dashboard;
