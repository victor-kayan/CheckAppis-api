import React, { Component } from "react";
import { Layout, Row, Col, Button, Alert } from "antd";
import BreadcrumbBee from "../../../../componentes/BreadcrumBee";
import Mapa from "../../../../componentes/Mapa";

class IndexApiario extends Component {
  constructor(props) {
    super(props);
    this.state = {
      home: {},
      loadingHome: false,
      qtd_apiarios: 0,
      qtd_colmeias: 0,
      qtd_apicultores: 0,
      visible: true,
      alertVisible: true
    };
  }

  handleCloseAlert = () => {
    this.setState({ visible: false });
  };

  render() {
    const mapa = [
      {
        key: "/",
        name: " Home",
        icon: "home"
      },
      {
        key: "apiarios/list",
        name: "Apicultores",
        icon: "banck"
      }
    ];

    return (
      <Layout.Content style={{ margin: "0 16px" }}>
        <BreadcrumbBee mapa={mapa} />

        <div
          style={{
            padding: 24,
            margin: 10,
            background: "#fff",
            minHeight: 360,
            boxShadow: "0 0 20px rgba(0, 0, 0, 0.1)"
          }}
        >
          <Alert
            message="Para cadastrar um novo apiário clique com o botão direito do mouse na região desejada do mapa"
            type="warning"
            closable
            onClose={this.handleCloseAlert}
            showIcon
            style={{fontSize: 16, fontWeight: 'bold',}}
          />
          <Row gutter={24}>
            <Col span={24}>
              <div style={{ marginTop: 30 }}>
                <Mapa height={"700px"} cadastroAbilitado={true} />
              </div>
            </Col>
          </Row>
        </div>
      </Layout.Content>
    );
  }
}

export default IndexApiario;
