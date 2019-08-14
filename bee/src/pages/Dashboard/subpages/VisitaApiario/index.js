import React from "react";
import "antd/dist/antd.css";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import {
  getAllApiariosVisitas,
  deleteVisitaApiario
} from "../../../../redux/actions/visitasApiarioActions";
import moment from "moment";
import "moment/locale/pt-br";

import {
  Table,
  Button,
  Layout,
  Popconfirm,
  notification,
  Icon,
  Tag
} from "antd";
import BreadcrumBee from "../../../../componentes/BreadcrumBee";
import lodash from "lodash";
import { colors } from "../../../../assets";
import ModalIntervir from "./ModalIntervir";

class VisitaApiario extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      modalVisible: false,
      visitasApiarios: {},
      apiarioId: null,
      pagination: {},
      currentPage: 0,
      isClicouButtonDelete: false
    };

    this.handleDelete = this.handleDelete.bind(this);
    this.openModalIntervir = this.openModalIntervir.bind(this);

    this.columns = [
      {
        title: "#ID",
        dataIndex: "id"
      },
      {
        title: "Apiário",
        dataIndex: "apiario.nome"
      },
      {
        title: "Tem água",
        dataIndex: "tem_agua",
        render: (text, record) => {
          return (
            <div>
              {text ? <Tag color="green">Sim</Tag> : <Tag color="red">Não</Tag>}
            </div>
          );
        }
      },
      {
        title: "Tem comida",
        dataIndex: "tem_comida",
        render: (text, record) => {
          return (
            <div>
              {text ? <Tag color="green">Sim</Tag> : <Tag color="red">Não</Tag>}
            </div>
          );
        }
      },
      {
        title: "Tem sombra",
        dataIndex: "tem_sombra",
        render: (text, record) => {
          return (
            <div>
              {text ? <Tag color="green">Sim</Tag> : <Tag color="red">Não</Tag>}
            </div>
          );
        }
      },
      {
        title: "Observação",
        dataIndex: "observacao"
      },
      {
        title: "Data",
        dataIndex: "created_at",
        render: (text, record) => {
          return <div>{moment(text).format("DD/MM/YYYY")}</div>;
        }
      },

      {
        title: "Ações",
        dataIndex: "acoes",
        render: (text, record) => {
          return (
            <div>
              <Button
                type="default"
                shape="circle"
                icon="setting"
                size="default"
                onClick={() => this.openModalIntervir(record)}
              />
              <Popconfirm
                title="Deletar visita?"
                okText="Sim"
                cancelText="Cancelar"
                onConfirm={() => this.handleDelete(record.id)}
              >
                <Button
                  type="default"
                  shape="circle"
                  icon="delete"
                  size="default"
                />
              </Popconfirm>
            </div>
          );
        }
      }
    ];
  }

  componentDidMount = () => {
    this.getAllVisitas();
  };

  componentWillReceiveProps(nextProps) {
    if (nextProps.code === 204 && this.state.isClicouButtonDelete) {
      notification.open({
        message: "Operação realizada com sucesso",
        description: "Visita removida com sucesso",
        icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
      });
      this.setState({ isClicouButtonDelete: false });
    } 
    if (!lodash.isEqual(this.props.list_apicultor, nextProps.visitasApiarios)) {
      const pagination = { ...this.state.pagination };

      pagination.total =
        nextProps.visitasApiarios && nextProps.visitasApiarios.total
          ? nextProps.visitasApiarios.total
          : 1;
      pagination.current =
        nextProps.visitasApiarios && nextProps.visitasApiarios.current_page
          ? nextProps.visitasApiarios.current_page
          : 1;
      pagination.pageSize =
        nextProps.visitasApiarios && nextProps.visitasApiarios.per_page
          ? nextProps.visitasApiarios.per_page
          : 1;

      this.setState({
        pagination
      });
    }
  }

  openModalIntervir = record => {
    this.setState({ apiarioId: record.apiario_id, modalVisible: true });
  };

  handleDelete = id => {
    this.props.deleteVisitaApiario(id);
    this.setState({ isClicouButtonDelete: true });
  };

  handleTableChange = (pagination, filters, sorter) => {
    const pager = { ...this.state.pagination };
    pager.current = pagination.current;
    this.setState({
      pagination: pager
    });
    this.getAllVisitas({
      results: pagination.pageSize,
      page: pagination.current,
      sortField: sorter.field,
      sortOrder: sorter.order,
      ...filters
    });
  };

  getAllVisitas = (params = {}) => {
    var currentPage =
      this.state.currentPage < this.state.pagination.last_page
        ? this.state.currentPage + 1
        : 1;
    var page =
      Object.keys({ ...params }).length === 0 ? currentPage : params.page;

    this.props.getAllApiariosVisitas(page);
    this.setState({ currentPage: page });
  };

  render() {
    const visitas = this.props.visitasApiarios || null;
    const { pagination, modalVisible, apiarioId } = this.state;

    const columns = this.columns.map(col => {
      return {
        ...col,
        onCell: record => ({
          record,
          editable: col.editable,
          dataindex: col.dataindex,
          title: col.title
        })
      };
    });

    const mapa = [
      {
        key: "/",
        name: " Home",
        icon: "home"
      },
      {
        key: "list",
        name: " Visitas Apiários",
        icon: "check"
      }
    ];

    return (
      <Layout.Content style={{ margin: "0 16px" }}>
        <BreadcrumBee mapa={mapa} />

        <div
          style={{
            padding: 24,
            background: "#fff",
            minHeight: 360,
            boxShadow: "0 0 20px rgba(0, 0, 0, 0.1)"
          }}
        >
          <Table
            columns={columns}
            dataSource={visitas.data}
            rowKey={record => record.id}
            pagination={pagination}
            loading={this.props.loadingVisita}
            onChange={this.handleTableChange}
            title={() => "Lista de visitas realizadas nos apiários"}
            footer={() => "Todos os resultados"}
            size="small"
            bordered
          />

          <ModalIntervir
            visible={modalVisible}
            apiarioId={apiarioId}
            onClose={() =>
              this.setState({ modalVisible: false, visitasApiarios: {} })
            }
            onCancel={() =>
              this.setState({ modalVisible: false, visitasApiarios: {} })
            }
          />
        </div>
      </Layout.Content>
    );
  }
}

function mapStateToProps(state, props) {
  return {
    visitasApiarios: state.visitaApiarioState.visitasApiarios,
    loadingVisita: state.visitaApiarioState.loadingVisita,
    code: state.visitaApiarioState.code
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    { getAllApiariosVisitas, deleteVisitaApiario },
    dispatch
  );
}

export default connect(
  mapStateToProps,
  mapDispatchToProps,
  null,
  { forwardRef: true }
)(VisitaApiario);
