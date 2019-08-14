import React, { Component } from "react";
import { Row, Layout, Radio, Button, Col, Divider, Icon } from "antd";
import BreadcrumbBee from "../../../../../componentes/BreadcrumBee";
import ButtonGroup from "antd/lib/button/button-group";
import { uris } from "../../../../../assets";

export class RelatorioIntervencao extends Component {
  state = {
    tipo_intervencao: "apiario",
    orintacaoPapel: "portrait",
    situacao: "is_concluidas"
  };

  onChange = e => {
    this.setState({
      tipo_intervencao: e.target.value
    });
  };

  onChangeOrientacaoPapel = e => {
    this.setState({
      orintacaoPapel: e.target.value
    });
  };

  onChangeSituacao = e => {
    this.setState({
      situacao: e.target.value
    });
  };

  handleDownload = () => {
    window.open(
      uris.BASE_URL +
        "tecnico/intervencoes/relatorios?token_relatorio=" +
        localStorage.getItem("token_relatorios") +
        "&tecnico_id=" +
        localStorage.getItem("tecnico_id") +
        "&situacao=" +
        this.state.situacao +
        "&tipo_intervencao=" +
        this.state.tipo_intervencao +
        "&orientacao_papel=" +
        this.state.orintacaoPapel +
        "&acao=download"
    );
  };

  handleVisualizar = () => {
    window.open(
      uris.BASE_URL +
        "tecnico/intervencoes/relatorios?token_relatorio=" +
        localStorage.getItem("token_relatorios") +
        "&tecnico_id=" +
        localStorage.getItem("tecnico_id") +
        "&situacao=" +
        this.state.situacao +
        "&tipo_intervencao=" +
        this.state.tipo_intervencao +
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

    const { tipo_intervencao, orintacaoPapel, situacao } = this.state;

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
                <Radio style={radioStyle} value="portrait">
                  Vertical
                </Radio>
                <Radio style={radioStyle} value="landscape">
                  Horizontal
                </Radio>
              </Radio.Group>
            </Col>
          </Row>

          {/* Seleção do tipo de intervenção */}

          <Row gutter={8}>
            <Col span={24}>
              <Divider orientation="left">
                Escolha o tipo de intervenção para emitir o relatório
              </Divider>
              <Radio.Group onChange={this.onChange} value={tipo_intervencao}>
                <Radio style={radioStyle} value="apiario">
                  Intervenção nos apiarios
                </Radio>
                <Radio style={radioStyle} value="colmeia">
                  Intervenção nas colmeias
                </Radio>
              </Radio.Group>

              <Divider orientation="left">
                Escolha a situação da intervenção
              </Divider>
              <Radio.Group onChange={this.onChangeSituacao} value={situacao}>
                <Radio style={radioStyle} value="is_concluidas">
                  Concluidas
                </Radio>
                <Radio style={radioStyle} value="is_nao_concluidas">
                  Não concluidas
                </Radio>
                <Radio style={radioStyle} value="todas_intervencoes">
                  Todas
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

export default RelatorioIntervencao;
