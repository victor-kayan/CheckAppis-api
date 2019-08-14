import React, { Component } from "react";
import "antd/dist/antd.css";
import "../../pages/Login/styles.css";
import { Form, Icon, Input, Button, Checkbox, Row, Typography } from "antd";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import { login } from "../../redux/actions/userActions";
import Logo from "../../images/logo.png";
import ModalEsqueciSenha from "../../componentes/ModalEsqueciSenha";
import AlertComponent from "../../componentes/Alert";
import Facebook from "../../componentes/FacebookLogin";
import { Redirect } from "react-router-dom";
import { colors } from "../../assets";

class Login extends Component {
  constructor(props) {
    super(props);
    this.state = {
      email: "",
      password: "",
      alertVisible: false,
      tentouLogar: false,
      message: ""
    };
    this.handleSubmit = this.handleSubmit.bind(this);
  }

  componentDidMount() {
    if (localStorage.getItem("token")) {
      return <Redirect to="/" />;
    }
  }

  componentWillReceiveProps(nextProps) {
    if (nextProps.autenticado === true) {
     
      return <Redirect to="/" />;
    } else if (
      !nextProps.autenticado &&
      !nextProps.loading &&
      this.state.tentouLogar
    ) {
      if (nextProps.code >= 500) {
        this.setState({
          alertVisible: true,
          message: "Aguarde!! Estamos tendo problemas no servidor"
        });
      } else {
        this.setState({
          alertVisible: true,
          message: "Email e/ou senha incorretas"
        });
      }
      this.setState({ tentouLogar: false });
      this.refs.alert.openAlert();
    }
  }

  esqueciSenha = () => {
    this.refs.openModal.setModalVisible(true);
  };

  handleSubmit = e => {
    e.preventDefault();
    this.props.form.validateFields((err, values) => {
      if (!err) {
        this.setState({ tentouLogar: true });
        this.props.login({ email: values.email, password: values.password });
      }
    });
  };

  render() {
    const { getFieldDecorator } = this.props.form;
    const { message, alertVisible } = this.state;
    const { Title } = Typography;

    return (
      <div className="container">
        <div className="box">
          <Form className="login-form">
            <Form.Item>
              <img className="logo" src={Logo} alt="Logo" />
              <Title level={2}>
                Bee
                <span style={{ color: colors.COR_YELLOW_PRINCIPAL }}>
                  Check
                </span>
              </Title>
            </Form.Item>

            <AlertComponent
              ref="alert"
              visible={alertVisible}
              type="error"
              message={message}
            />

            <Form.Item>
              {getFieldDecorator("email", {
                rules: [
                  {
                    type: "email",
                    message: "Informe um formato de email válido!"
                  },
                  {
                    required: true,
                    message: "Por favor informe seu email!"
                  }
                ]
              })(
                <Input
                  prefix={
                    <Icon type="mail" style={{ color: "rgba(0,0,0,.25)" }} />
                  }
                  placeholder="Email"
                />
              )}
            </Form.Item>

            <Form.Item>
              {getFieldDecorator("password", {
                rules: [
                  {
                    min: 5,
                    message: "Sua senha tem que ter no minimo 5 caracteres"
                  },
                  {
                    required: true,
                    message: "Por favor informe sua senha!"
                  }
                ]
              })(
                <Input.Password
                  prefix={
                    <Icon type="lock" style={{ color: "rgba(0,0,0,.25)" }} />
                  }
                  placeholder="Senha"
                />
              )}
            </Form.Item>

            <Form.Item>
              <Row className="">
                {getFieldDecorator("remember", {
                  valuePropName: "checked",
                  initialValue: true
                })(<Checkbox style={{ float: "left" }}>Lembrar-me</Checkbox>)}

                <a
                  style={{ float: "right" }}
                  className="login-form-forgot"
                  onClick={this.esqueciSenha}
                  href="#"
                >
                  Recuperar senha
                </a>
              </Row>
              <Row className="button">
                <Button
                  type="primary"
                  onClick={this.handleSubmit}
                  loading={this.props.loading}
                  className="login-form-button button"
                >
                  Entrar
                </Button>
              </Row>
              
              <Row className="button">
                <Facebook />
              </Row>

              <strong>
                Bee
                <strong style={{ color: colors.COR_YELLOW_PRINCIPAL }}>
                  Check
                </strong>{" "}
                - Gerencie já seu apiário
              </strong>
            </Form.Item>
          </Form>

          <ModalEsqueciSenha ref={"openModal"} />
        </div>
      </div>
    );
  }
}

const WrappedNormalLoginForm = Form.create({ name: "normal_login" })(Login);

function mapStateToProps(state, props) {
  return {
    user: state.userState.user,
    loading: state.userState.loading,
    loadingFacebook: state.userState.loadingFacebook,
    autenticado: state.userState.autenticado,
    token: state.userState.token,
    code: state.userState.code
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({ login }, dispatch);
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(WrappedNormalLoginForm);
