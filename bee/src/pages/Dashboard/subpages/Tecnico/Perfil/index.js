import React, { Component } from "react";
import {
  Col,
  Row,
  Layout,
  Form,
  Input,
  Icon,
  Divider,
  Button,
  Spin,
  notification,
  Tabs
} from "antd";
import BreadcrumbBee from "../../../../../componentes/BreadcrumBee";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import {
  getPerfil,
  updatePerfil
} from "../../../../../redux/actions/tecnicoActions";
import "./styles.css";
import { colors } from "../../../../../assets";
import MaskedInput from "antd-mask-input";
import patterns from "../../../../../assets/patterns";

class Perfil extends Component {
  constructor(props) {
    super(props);
    this.state = {
      userPerfil: {},
      isClicouButtonUpate: false
    };
  }

  componentDidMount = () => {
    this.props.getPerfil();
  };

  componentWillReceiveProps = nextProps => {
    if (this.state.isClicouButtonUpate) {
      if (nextProps && nextProps.code === 200) {
        notification.open({
          message: "Operação realizado com sucesso",
          description: nextProps.messagePerfil,
          icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
        });
      } else if (nextProps && nextProps.code === 422) {
        notification.open({
          message: "Falha ao realizar essa operação",
          description: nextProps.messagePerfil,
          icon: (
            <Icon
              type="smile"
              rotate={180}
              style={{ color: colors.COR_RED_ERROR }}
            />
          )
        });
      }
      this.setState({ isClicouButtonUpate: false });
    }
  };

  handleSubmit = () => {
    this.props.form.validateFields((err, values) => {
      if (!err) {
        this.setState({ isClicouButtonUpate: true });
        this.props.updatePerfil({
          request: values
        });
      }
    });
  };

  render() {
    const mapa = [
      {
        key: "/",
        name: " Home",
        icon: "home"
      },
      {
        key: "perfil",
        name: "Perfil",
        icon: "user"
      }
    ];

    const { getFieldDecorator } = this.props.form;
    const { loadingPerfil, userPerfil, loadingUpdatePerfil } =
      this.props || null;
    const { TabPane } = Tabs;

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
          <Row>
            <div
              style={{
                justifyContent: "center",
                alignItems: "center",
                display: "flex"
              }}
            >
              {loadingPerfil ? (
                <div
                  style={{
                    textAlign: "center",
                    justifyContent: "center",
                    alignItems: "center",
                    marginTop: 150
                  }}
                >
                  <Spin size="large" />
                </div>
              ) : (
                <Col span={15}>
                  <div style={{ boxShadow: "0 0 20px rgba(0, 0, 0, 0.1)" }}>
                    <div className="editarDadosPessoais">
                      <img
                        src={userPerfil.foto}
                        className="fotoPerfilEditar"
                        alt={"Perfil"}
                        style={{ padding: 5 }}
                      />
                    </div>

                    <div
                      style={{
                        padding: 24,
                        margin: 10,
                        background: "#fff",
                        minHeight: 360,
                        borderColor: "#000",
                        borderWidth: 1
                      }}
                    >
                      <Tabs>
                        <TabPane tab="Dados básicos" key="1">
                          <Form style={{ padding: "2vh" }}>
                            <Divider orientation="left">
                              Dados básicos do técnico
                            </Divider>

                            <div className="formStyle">
                              <Row gutter={24}>
                                <Col span={12}>
                                  <Form.Item label="Nome">
                                    {getFieldDecorator("name", {
                                      initialValue: userPerfil.name || "",
                                      rules: [
                                        {
                                          required: true,
                                          message: "Por favor informe um nome!"
                                        },
                                        {
                                          validator: this.compareToFirstPassword
                                        }
                                      ]
                                    })(
                                      <Input
                                        prefix={
                                          <Icon
                                            type="user"
                                            style={{ color: "rgba(0,0,0,.25)" }}
                                          />
                                        }
                                        onBlur={this.handleConfirmBlur}
                                        type="text"
                                        placeholder="Endereço"
                                      />
                                    )}
                                  </Form.Item>
                                </Col>

                                <Col span={12}>
                                  <Form.Item label="Email">
                                    {getFieldDecorator("email", {
                                      initialValue: userPerfil.email || "",
                                      rules: [
                                        {
                                          required: true,
                                          message:
                                            "Por favor informe seu email!"
                                        },
                                        {
                                          validator: this.compareToFirstPassword
                                        }
                                      ]
                                    })(
                                      <Input
                                        prefix={
                                          <Icon
                                            type="mail"
                                            style={{ color: "rgba(0,0,0,.25)" }}
                                          />
                                        }
                                        onBlur={this.handleConfirmBlur}
                                        type="text"
                                        placeholder="Endereço"
                                      />
                                    )}
                                  </Form.Item>
                                </Col>
                              </Row>

                              <Row gutter={8}>
                                <Col span={12}>
                                  <Form.Item label="Telefone">
                                    {getFieldDecorator("telefone", {
                                      initialValue: userPerfil.telefone || "",
                                      rules: [
                                        {
                                          required: true,
                                          message:
                                            "Por favor informe o telefone!"
                                        },
                                        {
                                          pattern: patterns.PHONE_FORMAT,
                                          message:
                                            "Informe de acordo com o formato"
                                        }
                                      ]
                                    })(
                                      <MaskedInput
                                        prefix={
                                          <Icon
                                            type="phone"
                                            style={{ color: "rgba(0,0,0,.25)" }}
                                          />
                                        }
                                        mask="(11) 11111-1111"
                                        name="card"
                                        placeholder="Telefone"
                                      />
                                    )}
                                  </Form.Item>
                                </Col>
                              </Row>
                            </div>

                            <Row gutter={8}>
                              <div className="buttonsAction">
                                <Button
                                  key="submit"
                                  type="primary"
                                  loading={loadingUpdatePerfil}
                                  onClick={this.handleSubmit}
                                >
                                  Salvar alterações
                                </Button>
                              </div>
                            </Row>
                          </Form>
                        </TabPane>

                        <TabPane tab="Senha" key="2">
                          <Form style={{ padding: "2vh" }}>
                            <Divider orientation="left">
                              Senha do técnico
                            </Divider>
                            <div className="formStyle">
                              <Row gutter={8}>
                                <Col span={12}>
                                  <Form.Item label="Insira uma senha">
                                    {getFieldDecorator("password", {
                                      rules: [
                                        {
                                          min: 5,
                                          message:
                                            "A senha tem que ter no minímo 5 caracteres!"
                                        },
                                        {
                                          max: 20,
                                          message:
                                            "A senha tem que ter no máximo 20 caracteres!"
                                        }
                                      ]
                                    })(
                                      <Input
                                        prefix={
                                          <Icon
                                            type="lock"
                                            style={{ color: "rgba(0,0,0,.25)" }}
                                          />
                                        }
                                        type="password"
                                        placeholder="Senha"
                                      />
                                    )}
                                  </Form.Item>
                                </Col>
                                <Col span={12}>
                                  <Form.Item label="Confirme a senha">
                                    {getFieldDecorator(
                                      "password_confirmation",
                                      {
                                        rules: [
                                          {
                                            min: 5,
                                            message:
                                              "A senha tem que ter no minímo 5 caracteres!"
                                          },
                                          {
                                            max: 20,
                                            message:
                                              "A senha tem que ter no máximo 20 caracteres!"
                                          },
                                          {
                                            validator: this
                                              .compareToFirstPassword
                                          }
                                        ]
                                      }
                                    )(
                                      <Input
                                        prefix={
                                          <Icon
                                            type="lock"
                                            style={{ color: "rgba(0,0,0,.25)" }}
                                          />
                                        }
                                        type="password"
                                        placeholder="Confirmar senha"
                                      />
                                    )}
                                  </Form.Item>
                                </Col>
                              </Row>
                            </div>

                            <Row gutter={8}>
                              <div className="buttonsAction">
                                <Button
                                  key="submit"
                                  type="primary"
                                  loading={loadingUpdatePerfil}
                                  onClick={this.handleSubmit}
                                >
                                  Salvar alterações
                                </Button>
                              </div>
                            </Row>
                          </Form>
                        </TabPane>
                      </Tabs>
                    </div>
                  </div>
                </Col>
              )}
            </div>
          </Row>
        </div>
      </Layout.Content>
    );
  }
}

const WrappedNormalLoginForm = Form.create({ name: "normal_login" })(Perfil);

function mapStateToProps(state, props) {
  return {
    userPerfil: state.tecnicoState.userPerfil,
    loadingPerfil: state.tecnicoState.loadingPerfil,
    loadingUpdatePerfil: state.tecnicoState.loadingUpdatePerfil,
    messagePerfil: state.tecnicoState.messagePerfil,
    code: state.tecnicoState.code
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({ getPerfil, updatePerfil }, dispatch);
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(WrappedNormalLoginForm);
