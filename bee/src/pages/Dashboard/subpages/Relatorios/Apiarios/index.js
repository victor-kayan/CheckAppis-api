import React, { Component } from "react";
import { Row, Layout, Button, Col, Divider, Radio, Icon } from "antd";
import BreadcrumbBee from "../../../../../componentes/BreadcrumBee";
import { uris } from "../../../../../assets";
import ButtonGroup from "antd/lib/button/button-group";

export class RelatorioApiario extends Component {
  state = {
    orintacaoPapel: "portrait"
  };

  handleDownload = () => {
    window.open(
      uris.BASE_URL +
        "tecnico/apiarios/relatorios?token_relatorio=" +
        localStorage.getItem("token_relatorios") +
        "&tecnico_id=" +
        localStorage.getItem("tecnico_id") +
        "&orientacao_papel=" +
        this.state.orintacaoPapel +
        "&acao=download"
    );
  };

  handleVisualizar = () => {
    window.open(
      uris.BASE_URL +
        "tecnico/apiarios/relatorios?token_relatorio=" +
        localStorage.getItem("token_relatorios") +
        "&tecnico_id=" +
        localStorage.getItem("tecnico_id") +
        "&orientacao_papel=" +
        this.state.orintacaoPapel +
        "&acao=visualizar"
    );
  };

  onChange = e => {
    this.setState({
      orintacaoPapel: e.target.value
    });
  };

  render() {
    const mapa = [
      {
        key: "",
        name: " Home",
        icon: "home"
      },
      {
        key: "",
        name: "Relatorios",
        icon: "file-search"
      }
    ];

    const radioStyle = {
      display: "block",
      height: "30px",
      lineHeight: "30px"
    };

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
          <Row gutter={8}>
            <Col span={24}>
              <Divider orientation="left">Orientação do papel</Divider>
              <Radio.Group
                onChange={this.onChange}
                value={this.state.orintacaoPapel}
              >
                <Radio style={radioStyle} value="portrait">
                  Vertical
                </Radio>
                <Radio style={radioStyle} value="landscape">
                  Horizontal
                </Radio>
              </Radio.Group>
            </Col>
          </Row>

          {/* Opções de ações */}

          <Row gutter={24}>
            <Col span={24}>
              <Divider orientation="left">Escolha uma das opções</Divider>

              <ButtonGroup>
                <Button type="primary" onClick={this.handleVisualizar}>
                  <Icon type="eye" />
                  Visualizar
                </Button>
                <Button type="primary" onClick={this.handleDownload}>
                  Download
                  <Icon type="download" />
                </Button>
              </ButtonGroup>
            </Col>
          </Row>
        </div>
      </Layout.Content>
    );
  }
}

export default RelatorioApiario;
