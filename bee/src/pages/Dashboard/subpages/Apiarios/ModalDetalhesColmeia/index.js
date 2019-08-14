import React from "react";
import "antd/dist/antd.css";
import "./styles.css";
import { Modal, Row, Col, Card, Avatar, Empty, Spin } from "antd";
const colmeiaIcon = require("../../../../../images/honeycomb.png");

class ModalDetalhesColmeia extends React.Component {
  state = {
    modalVisible: false
  };

  setModalVisible(modalVisible) {
    this.setState({ modalVisible });
  }

  render() {
    const { colmeias, loadingColmeia } = this.props || [];
    const { Meta } = Card;

    return (
      <div>
        <Modal
          title="Detalhes das colmeias do apiário"
          centered
          width={900}
          visible={this.state.modalVisible}
          onOk={() => this.setModalVisible(false)}
          onCancel={() => this.setModalVisible(false)}
          okText="Ok"
          cancelText="Cancelar"
          style={{ overflowY: "auto", margin: 25 }}
        >
          {loadingColmeia && (
            <div style={{ textAlign: "center" }}>
              <Spin />
            </div>
          )}

          {!loadingColmeia && (
            <Row gutter={24}>
              {colmeias.length > 0 &&
                colmeias.map(colmeia => (
                  <Col span={8} key={colmeia.id}>
                    <Card
                      loading={loadingColmeia}
                      style={{ height: 150, marginBottom: 7 }}
                      cover={
                        <Avatar
                          src={colmeiaIcon}
                          size={60}
                          style={{ padding: 10, textAlign: "center", justifyContent: 'center', alignItems: 'center', }}
                        />
                      }
                    >
                      <Meta
                        title={colmeia.nome}
                        description={colmeia.descricao}
                      />
                    </Card>
                  </Col>
                ))}

              {colmeias.length === 0 && (
                <Empty
                  description="Nenhuma colmeia cadastrada nesse apiário"
                  image={Empty.PRESENTED_IMAGE_SIMPLE}
                />
              )}
            </Row>
          )}
          <br />
        </Modal>
      </div>
    );
  }
}

export default ModalDetalhesColmeia;
