import React from "react";
import "antd/dist/antd.css";
import { connect } from "react-redux";
import { bindActionCreators } from "redux";
import {
  getAllApiariosIntervencoes,
  deleteIntervencaoApiario
} from "../../../../redux/actions/intervencoesApiarioActions/";
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

class IntevencaoApiario extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      modalVisible: false,
      intervencoesApiarios: {},
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
        title: "Descrição",
        dataIndex: "descricao"
      },
      {
        title: "Data inicio",
        dataIndex: "data_inicio"
      },
      {
        title: "Data Fim",
        dataIndex: "data_fim"
      },
      {
        title: "Concluida",
        dataIndex: "is_concluido",
        render: (text, record) => {
          return (
            <div>
              {text ? <Tag color="green">Sim</Tag> : <Tag color="red">Não</Tag>}
            </div>
          );
        }
      },
      {
        title: "Data de criação",
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
              <Popconfirm
                title="Deletar intervenção?"
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
    this.getAllIntervencoes();
  };

  componentWillReceiveProps(nextProps) {
    if (nextProps.code === 204 && this.state.isClicouButtonDelete) {
      notification.open({
        message: "Operação realizada com sucesso",
        description: "Intervenção removida com sucesso",
        icon: <Icon type="smile" style={{ color: colors.COR_PRYMARY }} />
      });
      this.setState({ isClicouButtonDelete: false });
    } else if (nextProps.code !== 204 && this.state.isClicouButtonDelete) {
      notification.open({
        message: "Erro ao executar essa operação",
        description: "Por favor tente novamente",
        icon: (
          <Icon
            type="smile"
            rotate={180}
            style={{ color: colors.COR_RED_ERROR }}
          />
        )
      });
      this.setState({ isClicouButtonDelete: false });
    }
    if (
      !lodash.isEqual(this.props.list_apicultor, nextProps.intervencoesApiarios)
    ) {
      const pagination = { ...this.state.pagination };

      pagination.total =
        nextProps.intervencoesApiarios && nextProps.intervencoesApiarios.total
          ? nextProps.intervencoesApiarios.total
          : 1;
      pagination.current =
        nextProps.intervencoesApiarios &&
        nextProps.intervencoesApiarios.current_page
          ? nextProps.intervencoesApiarios.current_page
          : 1;
      pagination.pageSize =
        nextProps.intervencoesApiarios &&
        nextProps.intervencoesApiarios.per_page
          ? nextProps.intervencoesApiarios.per_page
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
    this.props.deleteIntervencaoApiario(id);
    this.setState({ isClicouButtonDelete: true });
  };

  handleTableChange = (pagination, filters, sorter) => {
    const pager = { ...this.state.pagination };
    pager.current = pagination.current;
    this.setState({
      pagination: pager
    });
    this.getAllIntervencoes({
      results: pagination.pageSize,
      page: pagination.current,
      sortField: sorter.field,
      sortOrder: sorter.order,
      ...filters
    });
  };

  getAllIntervencoes = (params = {}) => {
    var currentPage =
      this.state.currentPage < this.state.pagination.last_page
        ? this.state.currentPage + 1
        : 1;
    var page =
      Object.keys({ ...params }).length === 0 ? currentPage : params.page;

    this.props.getAllApiariosIntervencoes(page);
    this.setState({ currentPage: page });
  };

  render() {
    const visitas = this.props.intervencoesApiarios || null;
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
        name: " Intervenções nos apiários",
        icon: "setting"
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
            loading={this.props.loadingIntervencao}
            onChange={this.handleTableChange}
            title={() => "Lista de de intervenções nos apiários"}
            footer={() => "Todos os resultados"}
            size="small"
            bordered
          />
        </div>
      </Layout.Content>
    );
  }
}

function mapStateToProps(state, props) {
  return {
    intervencoesApiarios: state.intervencaoApiarioState.intervencoesApiarios,
    loadingIntervencao: state.intervencaoApiarioState.loadingIntervencao,
    code: state.intervencaoApiarioState.code
  };
}

function mapDispatchToProps(dispatch) {
  return bindActionCreators(
    { getAllApiariosIntervencoes, deleteIntervencaoApiario },
    dispatch
  );
}

export default connect(
  mapStateToProps,
  mapDispatchToProps,
  null,
  { forwardRef: true }
)(IntevencaoApiario);
