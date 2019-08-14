import React, { Component } from "react";
import { Row, Layout, Col, Card } from "antd";
import BreadcrumbBee from "../../../../componentes/BreadcrumBee";

export class Error extends Component {
  render() {
    const mapa = [
      {
        key: "",
        name: "Home",
        icon: "home"
      },
      {
        key: "",
        name: "Não encontrado",
        icon: "error"
      }
    ];

    const { Meta } = Card;

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
          <Row gutter={8}>
            {/* <Col span={24}> */}
              <Card
                style={{
                  textAlign: "center",
                  justifyContent: "center",
                  alignItems: "center"
                }}
                hoverable
                style={{ width: 550 }}
                cover={
                  <img
                    alt="example"
                    src={require("../../../../images/page404.png")}
                  />
                }
              >
                <Meta
                  title="Europe Street beat"
                  description="www.instagram.com"
                />
              </Card>
            {/* </Col> */}
          </Row>
        </div>
      </Layout.Content>
    );
  }
}

export default Error;
