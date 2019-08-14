import React from "react";
import { Form, Input, Icon, Divider, Row, Col, Select } from "antd";
import MaskedInput from "antd-mask-input";
import Patterns from "../../../../../assets/patterns";

class FormApicultor extends React.Component {
  constructor(props) {
    super(props);
    this.state = {};
  }

  onChangeSelectEstado = uf => {
    this.props.handleChangeSelectEstado(uf);
    this.props.form.setFieldsValue({
      cidade_id: null
    });
  };

  render() {
    const { getFieldDecorator } = this.props.form;
    const cidades = this.props.listCidades || [];
    const { apicultor } = this.props || [];
    const { Option } = Select;

    return (
      <div>
        <Divider orientation="left">Dados básicos do apicultor</Divider>

        <Form onSubmit={this.handleSubmit}>
          <Row gutter={8}>
            <Col span={12}>
              <Form.Item label="Nome do usuário">
                {getFieldDecorator("name", {
                  initialValue: apicultor.name || "",
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe um nome"
                    },
                    {
                      min: 5,
                      message: "O campo tem que ter no minímo 5 caraceteres"
                    },
                    {
                      max: 50,
                      message: "O campo tem que ter no máximo 50 caraceteres"
                    }
                  ]
                })(
                  <Input
                    prefix={
                      <Icon type="user" style={{ color: "rgba(0,0,0,.25)" }} />
                    }
                    placeholder="Ex.: Claudio Rodrigo "
                  />
                )}
              </Form.Item>
            </Col>

            <Col span={12}>
              <Form.Item label="Insira o email do usuário">
                {getFieldDecorator("email", {
                  initialValue: apicultor.email || "",
                  rules: [
                    {
                      type: "email",
                      message: "Por favor informe um email válido!"
                    },
                    {
                      required: true,
                      message: "Por favor informe um E-mail!"
                    }
                  ]
                })(
                  <Input
                    prefix={
                      <Icon type="mail" style={{ color: "rgba(0,0,0,.25)" }} />
                    }
                    placeholder="Ex.: claudiorodrigozh@gmail.com"
                  />
                )}
              </Form.Item>
            </Col>
          </Row>

          <Row gutter={8}>
            <Col span={8}>
              <Form.Item label="Telefone">
                {getFieldDecorator("telefone", {
                  initialValue: apicultor.telefone || "",
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe o telefone!"
                    },
                    {
                      pattern: Patterns.PHONE_FORMAT,
                      message: "Informe de acordo com o formato"
                    }
                  ]
                })(
                  <MaskedInput
                    prefix={
                      <Icon type="phone" style={{ color: "rgba(0,0,0,.25)" }} />
                    }
                    mask="(11) 11111-1111"
                    name="card"
                    placeholder="Ex.: (84) 99999-9999"
                  />
                )}
              </Form.Item>
            </Col>
            <Col span={8}>
              <Form.Item label="Insira uma senha">
                {getFieldDecorator("password", {
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe uma senha!"
                    },
                    {
                      validator: this.validateToNextPassword
                    },
                    {
                      min: 5,
                      message: "No minímo 6 caracteres"
                    },
                    {
                      max: 30,
                      message: "No máximo 30 caracteres"
                    }
                  ]
                })(
                  <Input
                    prefix={
                      <Icon type="lock" style={{ color: "rgba(0,0,0,.25)" }} />
                    }
                    type="password"
                    placeholder="Ex.: beecheck"
                  />
                )}
              </Form.Item>
            </Col>

            <Col span={8}>
              <Form.Item label="Confirme a senha">
                {getFieldDecorator("password_confirmation", {
                  rules: [
                    {
                      required: true,
                      message: "Por favor confirme a senha!"
                    },
                    {
                      validator: this.compareToFirstPassword
                    }
                  ]
                })(
                  <Input
                    prefix={
                      <Icon type="lock" style={{ color: "rgba(0,0,0,.25)" }} />
                    }
                    onBlur={this.handleConfirmBlur}
                    type="password"
                    placeholder="Ex.: beecheck"
                  />
                )}
              </Form.Item>
            </Col>
          </Row>

          <Divider orientation="left">Endereço</Divider>

          <Row gutter={8}>
            <Col span={12}>
              <Form.Item label="Estado">
                {getFieldDecorator("estado", {
                  initialValue:
                    (apicultor.endereco && apicultor.endereco.cidade.uf) || [],

                  rules: [
                    {
                      required: true,
                      message: "Por favor selecione o estado!"
                    }
                  ]
                })(
                  <Select
                    showSearch
                    placeholder="Ex.: RN"
                    optionFilterProp="children"
                    onChange={value => this.onChangeSelectEstado(value)}
                    onFocus={this.props.onFocus}
                    onBlur={this.props.onBlur}
                    onSearch={this.props.onSearch}
                    filterOption={(input, option) =>
                      option.props.children
                        .toLowerCase()
                        .indexOf(input.toLowerCase()) >= 0
                    }
                  >
                    <Option value="AC">Acre</Option>
                    <Option value="AL">Alagoas</Option>
                    <Option value="AP">Amapá</Option>
                    <Option value="AM">Amazonas</Option>
                    <Option value="BA">Bahia</Option>
                    <Option value="CE">Ceará</Option>
                    <Option value="DF">Distrito Federal</Option>
                    <Option value="ES">Espírito Santo</Option>
                    <Option value="GO">Goiás</Option>
                    <Option value="MA">Maranhão</Option>
                    <Option value="MT">Mato Grosso</Option>
                    <Option value="MS">Mato Grosso do Sul</Option>
                    <Option value="MG">Minas Gerais</Option>
                    <Option value="PA">Pará</Option>
                    <Option value="PB">Paraíba</Option>
                    <Option value="PR">Paraná</Option>
                    <Option value="PE">Pernambuco</Option>
                    <Option value="PI">Piauí</Option>
                    <Option value="RJ">Rio de Janeiro</Option>
                    <Option value="RN">Rio Grande do Norte</Option>
                    <Option value="RS">Rio Grande do Sul</Option>
                    <Option value="RO">Rondônia</Option>
                    <Option value="RR">Roraima</Option>
                    <Option value="SC">Santa Catarina</Option>
                    <Option value="SP">São Paulo</Option>
                    <Option value="SE">Sergipe</Option>
                    <Option value="TO">Tocantins</Option>
                    <Option value="EX">Estrangeiro</Option>
                  </Select>
                )}
              </Form.Item>
            </Col>

            <Col span={12}>
              <Form.Item label="Cidade">
                {getFieldDecorator("cidade_id", {
                  initialValue:
                    (apicultor.endereco && apicultor.endereco.cidade.nome) ||
                    [],

                  rules: [
                    {
                      required: true,
                      message: "Por favor selecione a cidade!"
                    }
                  ]
                })(
                  <Select
                    showSearch
                    placeholder="Ex.: Portalegre"
                    optionFilterProp="children"
                    onChange={null}
                    onFocus={this.props.onFocus}
                    onSearch={this.props.onSearch}
                    filterOption={(input, option) =>
                      option.props.children
                        .toLowerCase()
                        .indexOf(input.toLowerCase()) >= 0
                    }
                  >
                    {cidades.map(cidade => (
                      <Option key={cidade.id} value={cidade.id}>
                        {cidade.nome}
                      </Option>
                    ))}
                  </Select>
                )}
              </Form.Item>
            </Col>
          </Row>

          <Row gutter={8}>
            <Col span={12}>
              <Form.Item label="Endereço">
                {getFieldDecorator("logradouro", {
                  initialValue:
                    (apicultor.endereco && apicultor.endereco.logradouro) || "",
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe um endereço!"
                    },
                    {
                      validator: this.compareToFirstPassword
                    }
                  ]
                })(
                  <Input
                    prefix={
                      <Icon
                        type="environment"
                        style={{ color: "rgba(0,0,0,.25)" }}
                      />
                    }
                    onBlur={this.handleConfirmBlur}
                    type="text"
                    placeholder="Ex.: Sitio Belo Monte"
                  />
                )}
              </Form.Item>
            </Col>
          </Row>
        </Form>
      </div>
    );
  }
}

const WrappedNormalLoginForm = Form.create({ name: "normal_login" })(
  FormApicultor
);

export default WrappedNormalLoginForm;
