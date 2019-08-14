import React from "react";
import { Form, Row, Col, DatePicker } from "antd";
import TextArea from "antd/lib/input/TextArea";

class FormIntervirVisitaColmeia extends React.Component {
  constructor(props) {
    super(props);
    this.state = {};
  }

  render() {
    const { getFieldDecorator } = this.props.form;

    return (
      <Row gutter={8}>
        <Form onSubmit={this.handleSubmit}>
          <Row gutter={8}>
            <Col span={24}>
              <Form.Item label="Descreva o que deve ser realizado na intervenção">
                {getFieldDecorator("descricao", {
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe uma itervenção"
                    },
                    {
                      min: 5,
                      message: "O campo tem que ter no minímo 5 caracteres"
                    },
                    {
                      max: 50,
                      message: "O campo tem que ter no máximo 50 caracteres"
                    }
                  ]
                })(
                  <TextArea
                    rows={2}
                    placeholder="Ex.: Colocar comida próximo as colmeias"
                  />
                )}
              </Form.Item>
            </Col>
          </Row>
          <Row gutter={8}>
            <Col span={12}>
              <Form.Item label="Data Início">
                {getFieldDecorator("data_inicio", {
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe uma data"
                    }
                  ]
                })(
                  <DatePicker
                    onChange={this.onChangeDate}
                    placeholder="Ex.: 24-10-2019"
                    defaultPickerValue={null}
                  />
                )}
              </Form.Item>
            </Col>
            <Col span={12}>
              <Form.Item label="Data Final">
                {getFieldDecorator("data_fim", {
                  rules: [
                    {
                      required: true,
                      message: "Por favor informe uma data"
                    }
                  ]
                })(
                  <DatePicker
                    onChange={this.onChangeDate}
                    placeholder="Ex.: 24-11-2019"
                    defaultPickerValue={null}
                  />
                )}
              </Form.Item>
            </Col>
          </Row>
        </Form>
      </Row>
    );
  }
}

const WrappedNormalLoginForm = Form.create({ name: "normal_login" })(
  FormIntervirVisitaColmeia
);

export default WrappedNormalLoginForm;
