import React, { Component } from "react";
import { Col, Row, Layout, notification, Icon } from "antd";
import BreadcrumBee from "../../../../componentes/BreadcrumBee";
import CardBee from "../../../../componentes/CardBee";
import apiario from "../../../../images/bee-hive.png";
import colmeia from "../../../../images/honeycomb.png";
import apicultor from "../../../../images/apiarist.png";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import { getAllInfoHome } from "../../../../redux/actions/homeActions";
import Mapa from "../../../../componentes/Mapa";
import { colors } from "../../../../assets";

class Home extends Component {
  constructor(props) {
    super(props);
    this.state = {
      home: {},
      loadingHome: false,
      qtd_apiarios: 0,
      qtd_colmeias: 0,
      qtd_apicultores: 0
    };
  }

  componentDidMount = () => {
    if (localStorage.getItem("primeiroAcesso")) {
      notification.open({
        message: "Bem vindo",
        description: localStorage.getItem("userName"),
        icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
      });
    }
    localStorage.removeItem("primeiroAcesso");

    this.props.getAllInfoHome();
  };

  render() {
    const mapa = [
      {
        key: "",
        name: " Home",
        icon: "home"
      }
    ];

    const { qtd_apiarios, qtd_colmeias, qtd_apicultores } = this.props.home;

    return (
      <Layout.Content style={{ margin: "0 16px" }}>
        <BreadcrumBee mapa={mapa} />

        <div
          style={{
            padding: 24,
            margin: 10,
            background: "#fff",
            minHeight: 360,
            boxShadow: "0 0 20px rgba(0, 0, 0, 0.1)"
          }}
        >
          <Row gutter={24}>
            <Col span={8}>
              <CardBee
                urlIcon={apiario}
                title="Quantidade de apiários"
                description={qtd_apiarios || 0 + " Apiários"}
                loading={this.props.loadingHome}
                minWidth={150}
                height={150}
                iconSize={60}
                borderRadiusCustom={5}
              />
            </Col>
            <Col span={8}>
              <CardBee
                urlIcon={colmeia}
                title="Quantidade de colmeias"
                description={qtd_colmeias || 0 + " Colmeias"}
                loading={this.props.loadingHome}
                minWidth={150}
                height={150}
                iconSize={60}
                borderRadiusCustom={5}
              />
            </Col>
            <Col span={8}>
              <CardBee
                urlIcon={apicultor}
                title="Quantidade de apicultores"
                description={qtd_apicultores || 0 + " Apicultores"}
                loading={this.props.loadingHome}
                minWidth={150}
                height={150}
                iconSize={60}
                borderRadiusCustom={5}
              />
            </Col>
          </Row>
          <Row gutter={24}>
            <Col span={24}>
              <div style={{ marginTop: 30 }}>
                <Mapa height={'500px'} cadastroAbilitado={false}/>
              </div>
            </Col>
          </Row>
        </div>
      </Layout.Content>
    );
  }
}

function mapStateToProps(state, props) {
  return {
    home: state.homeState.home,
    loadingHome: state.homeState.loadingHome,
    code: state.homeState.code
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({ getAllInfoHome }, dispatch);
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(Home);
