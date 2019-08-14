import React from "react";
import "antd/dist/antd.css";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import {
  getAllapicultor,
  deleteApicultor
} from "../../../../../redux/actions/apicultorActions";

import {
  Table,
  Button,
  Layout,
  Tag,
  Popconfirm,
  notification,
  Icon
} from "antd";
import BreadcrumBee from "../../../../../componentes/BreadcrumBee";
import ModalApicultor from "../ModalApicultor";
import lodash from "lodash";
import { colors } from "../../../../../assets";

class ListApicultor extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      visible: false,
      visibleModalEdit: false,
      apicultor: {},
      pagination: {},
      currentPage: 0,
      is_edicao: false
    };

    this.handleOpenModal = this.handleOpenModal.bind(this);
    this.handleDelete = this.handleDelete.bind(this);

    this.columns = [
      {
        title: "#ID",
        dataIndex: "id"
      },
      {
        title: "Nome",
        dataIndex: "name"
      },
      {
        title: "Email",
        dataIndex: "email"
      },
      {
        title: "Telefone",
        dataIndex: "telefone"
      },
      {
        title: "Cidade",
        dataIndex: "endereco.cidade.nome"
      },
      {
        title: "Endereço",
        dataIndex: "endereco.logradouro"
      },
      {
        title: "Qtd apiários",
        dataIndex: "qtdApiarios",
        render: text => {
          return (
            <span>
              <Tag color="blue" key={"tag"}>
                {text}
              </Tag>
            </span>
          );
        }
      },
      {
        title: "Qtd colmeias",
        dataIndex: "qtdColmeias",
        render: text => {
          return (
            <span>
              <Tag color="blue" key={"tag 2"}>
                {text ? text : 0}
              </Tag>
            </span>
          );
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
                icon="form"
                size="default"
                onClick={() => this.handleOpenModalEdit(record)}
              />
              <Popconfirm
                title="Deletar apicultor?"
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
    this.getAllapicultores();
  };

  componentWillReceiveProps(nextProps) {
    if (nextProps.code === 204) {
      notification.open({
        message: "Operação realizada com sucesso",
        description: "Apicultor removido com sucesso",
        icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
      });
    }
    if (!lodash.isEqual(this.props.list_apicultor, nextProps.list_apicultor)) {
      const pagination = { ...this.state.pagination };

      pagination.total =
        nextProps.list_apicultor && nextProps.list_apicultor.total
          ? nextProps.list_apicultor.total
          : 1;
      pagination.current =
        nextProps.list_apicultor && nextProps.list_apicultor.current_page
          ? nextProps.list_apicultor.current_page
          : 1;
      pagination.pageSize =
        nextProps.list_apicultor && nextProps.list_apicultor.per_page
          ? nextProps.list_apicultor.per_page
          : 1;

      this.setState({
        pagination
      });
    }
  }

  handleOpenModalEdit = record => {
    if (this.state.visibleModalEdit === true) {
      this.setState({ apicultor: {} });
    } else {
      this.setState({ apicultor: record, visible: true, is_edicao: true });
    }
  };

  handleDelete = id => {
    this.props.deleteApicultor({ id });
  };

  handleOpenModal = () => {
    this.setState({ visible: true });
  };

  handleTableChange = (pagination, filters, sorter) => {
    const pager = { ...this.state.pagination };
    pager.current = pagination.current;
    this.setState({
      pagination: pager
    });
    this.getAllapicultores({
      results: pagination.pageSize,
      page: pagination.current,
      sortField: sorter.field,
      sortOrder: sorter.order,
      ...filters
    });
  };

  getAllapicultores = (params = {}) => {
    var currentPage =
      this.state.currentPage < this.state.pagination.last_page
        ? this.state.currentPage + 1
        : 1;
    var page =
      Object.keys({ ...params }).length === 0 ? currentPage : params.page;

    this.props.getAllapicultor(page);
    this.setState({ currentPage: page });
  };

  render() {
    const apicultores = this.props.list_apicultor || [];
    const { visible, pagination } = this.state;

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
        name: "Apicultores",
        icon: "team"
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
          <div>
            <Button
              onClick={this.handleOpenModal}
              style={{ marginBottom: 16 }}
              type="primary"
              icon="plus"
            >
              Novo apicultor
            </Button>
          </div>
          <Table
            columns={columns}
            dataSource={apicultores.data}
            rowKey={record => record.id}
            pagination={pagination}
            loading={this.props.loading}
            onChange={this.handleTableChange}
            title={() => "Lista de apicultores cadastrados"}
            footer={() => "Todos os resultados"}
            size="small"
            bordered
          />
        </div>

        <ModalApicultor
          visible={visible}
          apicultor={this.state.apicultor}
          edicao={this.state.is_edicao}
          onClose={() =>
            this.setState({ visible: false, is_edicao: false, apicultor: {} })
          }
          onCancel={() =>
            this.setState({ visible: false, is_edicao: false, apicultor: {} })
          }
        />
      </Layout.Content>
    );
  }
}

function mapStateToProps(state, props) {
  return {
    list_apicultor: state.apicultorState.list_apicultor,
    loading: state.apicultorState.loading,
    code: state.apicultorState.code
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators({ getAllapicultor, deleteApicultor }, dispatch);
}

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(ListApicultor);
