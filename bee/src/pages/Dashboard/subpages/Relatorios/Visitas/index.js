import React, { Component } from "react";
import { Row, Layout, Radio, Button, Col, Divider, Icon } from "antd";
import BreadcrumbBee from "../../../../../componentes/BreadcrumBee";
import { uris } from "../../../../../assets";
import ButtonGroup from "antd/lib/button/button-group";

export class RelatorioVisitas extends Component {
  state = {
    disabled: false,
    tipoVisita: "apiario",
    orintacaoPapel: "portrait"
  };

  onChange = e => {
    this.setState({
      tipoVisita: e.target.value
    });

    if (e.target.value === "colmeia") {
      this.setState({ disabled: true, orintacaoPapel: 'landscape' });
    } else {
      this.setState({ disabled: false });
    }
  };

  onChangeOrientacaoPapel = e => {
    this.setState({
      orintacaoPapel: e.target.value
    });
  };

  handleDownload = () => {
    window.open(
      uris.BASE_URL +
        "tecnico/visitas/relatorios?token_relatorio=" +
        localStorage.getItem("token_relatorios") +
        "&tecnico_id=" +
        localStorage.getItem("tecnico_id") +
        "&tipo_visita=" +
        this.state.tipoVisita +
        "&orientacao_papel=" +
        this.state.orintacaoPapel +
        "&acao=download"
    );
  };

  handleVisualizar = () => {
    window.open(
      uris.BASE_URL +
        "tecnico/visitas/relatorios?token_relatorio=" +
        localStorage.getItem("token_relatorios") +
        "&tecnico_id=" +
        localStorage.getItem("tecnico_id") +
        "&tipo_visita=" +
        this.state.tipoVisita +
        "&orientacao_papel=" +
        this.state.orintacaoPapel +
        "&acao=visualizar"
    );
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

    const { disabled, tipoVisita, orintacaoPapel } = this.state;

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
                onChange={this.onChangeOrientacaoPapel}
                value={orintacaoPapel}
              >
                <Radio style={radioStyle} value="portrait" disabled={disabled}>
                  Vertical
                </Radio>
                <Radio style={radioStyle} value="landscape">
                  Horizontal
                </Radio>
              </Radio.Group>
            </Col>
          </Row>
          <Row gutter={8}>
            <Col span={24}>
              <Divider orientation="left">
                Escolha o tipo de visita para emitir o relatório
              </Divider>
              <Radio.Group onChange={this.onChange} value={tipoVisita}>
                <Radio style={radioStyle} value="apiario">
                  Visitas nos apiarios
                </Radio>
                <Radio style={radioStyle} value="colmeia">
                  Visitas nas colmeias
                </Radio>
              </Radio.Group>
            </Col>
          </Row>

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

export default RelatorioVisitas;
