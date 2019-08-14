import React from "react";
import { Modal, Button, Form, Icon, notification } from "antd";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import { saveIntervencaoColmeia } from "../../../../../redux/actions/visitasColmeiaActions";
import FormVisitaApiario from "./FormIntervirVisitaColmeia";
import { colors } from "../../../../../assets";

class ModalIntervirColmeia extends React.Component {
  state = {
    visible: false,
    message: "",
    clicouButtonSave: false
  };

  componentWillReceiveProps(nextProps) {
    if (this.state.clicouButtonSave) {
      if (nextProps.code === 201 || nextProps.code === 200) {
        notification.open({
          message: "Operação realizada com sucesso",
          description: nextProps.messageVisita,
          icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
        });

        this.props.onCancel();
      } else {
        notification.open({
          message: "Falha ao realizar essa operação",
          description: nextProps.messageVisita,
          icon: (
            <Icon
              type="smile"
              rotate={180}
              style={{ color: colors.COR_RED_ERROR }}
            />
          )
        });
      }
      this.setState({ clicouButtonSave: false });
    }
  }

  handleCancel = () => {
    this.setState({ visible: false });
  };

  handleSubmit = () => {
    this.refs.formVisitaApiario.validateFields((err, values) => {
      if (!err) {
        this.setState({ clicouButtonSave: true });
        this.props.saveIntervencaoColmeia({
          descricao: values.descricao,
          data_inicio: values.data_inicio,
          data_fim: values.data_fim,
          colmeia_id: this.props.colmeiaId
        });
      }
    });
  };

  render() {
    const { visible, onClose } = this.props;

    return (
      <Modal
        ref="openModal"
        visible={visible}
        width={500}
        title={"Cadastrar intervenção"}
        onCancel={onClose}
        destroyOnClose
        auto
        footer={[
          <Button key="back" onClick={onClose}>
            Cancelar
          </Button>,
          <Button
            key="submit"
            type="primary"
            loading={this.props.loadingVisita}
            onClick={this.handleSubmit}
          >
            Salvar Intervenção
          </Button>
        ]}
        style={{ paddingLeft: "24px", paddingRight: "24px" }}
      >
        <FormVisitaApiario ref="formVisitaApiario" />
      </Modal>
    );
  }
}

const WrappedRegistrationForm = Form.create({ name: "register" })(
  ModalIntervirColmeia
);

function mapStateToProps(state, props) {
  return {
    visitasApiarios: state.visitaColmeiaState.visitasApiarios,
    loadingVisita: state.visitaColmeiaState.loadingVisita,
    code: state.visitaColmeiaState.code,
    messageVisita: state.visitaColmeiaState.messageVisita
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({ saveIntervencaoColmeia }, dispatch);
}

export default connect(
  mapStateToProps,
  mapDispatchToProps,
  null,
  { forwardRef: true }
)(WrappedRegistrationForm);
