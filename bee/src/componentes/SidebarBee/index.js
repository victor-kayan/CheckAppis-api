import React, { Component } from "react";
import "antd/dist/antd.css";
import Logo from "../../images/logo.png";
import { Layout, Menu, Icon, Avatar } from "antd";
import { Link } from "react-router-dom";

class SidebarBee extends Component {
  state = {
    collapsed: false
  };

  onCollapse = collapsed => {
    this.setState({ collapsed });
  };

  render() {
    const { Sider } = Layout;
    const SubMenu = Menu.SubMenu;

    return (
      <Sider
        collapsible
        collapsed={this.state.collapsed}
        onCollapse={this.onCollapse}
      >
        <div style={{ textAlign: "center" }}>
          <Avatar
            style={{
              width: "50px",
              height: "50px",
              marginTop: "10px",
              marginBottom: "10px",
              textAlign: "center"
            }}
            size={64}
            src={Logo}
          />
        </div>
        <Menu theme="dark" mode="inline">
          <Menu.Item key="/home">
            <Link to="/">
              <Icon type="home" />
              <span>Home</span>
            </Link>
          </Menu.Item>

          <Menu.Item key="perfil">
            <Link to="/tecnico/perfil">
              <span>
                <Icon type="user" />
                <span>Perfil</span>
              </span>
            </Link>
          </Menu.Item>

          <SubMenu
            key="sub3"
            title={
              <span>
                <Icon type="team" />
                <span>Apicultores</span>
              </span>
            }
          >
            <Menu.Item key="5">
              <Link to="/apicultores/list">Listar</Link>
            </Menu.Item>
          </SubMenu>
          <SubMenu
            key="sub4"
            title={
              <span>
                <Icon type="bank" />
                <span>Apiários</span>
              </span>
            }
          >
            <Menu.Item key="8">
              <Link to="/apiarios/list">Listar/Cadastrar</Link>
            </Menu.Item>
          </SubMenu>
          <SubMenu
            key="sub5"
            title={
              <span>
                <Icon type="check-circle" />
                <span>Visitas</span>
              </span>
            }
          >
            <Menu.Item key="9">
              <Link to="/apiarios/visitas">Apiários</Link>
            </Menu.Item>

            <Menu.Item key="10">
              <Link to="/colmeias/visitas">Colmeias</Link>
            </Menu.Item>
          </SubMenu>
          <SubMenu
            key="sub6"
            title={
              <span>
                <Icon type="setting" />
                <span>Intervenções</span>
              </span>
            }
          >
            <Menu.Item key="11">
              <Link to="/intervencoes/apiarios/">Apiários</Link>
            </Menu.Item>
            <Menu.Item key="12">
              <Link to="/intervencoes/colmeias">Colmeias</Link>
            </Menu.Item>
          </SubMenu>
          <SubMenu
            key="sub7"
            title={
              <span>
                <Icon type="file-search" />
                <span>Relatórios</span>
              </span>
            }
          >
            <Menu.Item key="13">
              <Link to="/apiarios/relatorios/">Apiários</Link>
            </Menu.Item>
            <Menu.Item key="14">
              <Link to="/visitas/relatorios">Visitas</Link>
            </Menu.Item>
            <Menu.Item key="15">
              <Link to="/intervencoes/relatorios">Intervenções</Link>
            </Menu.Item>
          </SubMenu>
        </Menu>
      </Sider>
    );
  }
}

export default SidebarBee;
