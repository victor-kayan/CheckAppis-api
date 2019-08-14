import React, { Component } from "react";
import { Card, Avatar } from "antd";
import colors from "../../assets/colors";

const { Meta } = Card;
class CardBee extends Component {
  render() {
    return (
      <Card
        style={{
          height: this.props.height,
          minWidth: this.props.minWidth,
          borderRadius: this.props.borderRadiusCustom,
          boxShadow: "0 0 20px rgba(0, 0, 0, 0.1)",
          fontSize: '3vh'
        }}
        loading={this.props.loading}
      >
        <Meta
          avatar={
            <div
              style={{
                padding: 20,
                backgroundColor: colors.COR_YELLOW_SECUNDARIA,
                borderRadius: 50
              }}
            >
              <Avatar
                size={this.props.iconSize}
                src={this.props.urlIcon}
                style={{ padding: 10 }}
              />
            </div>
          }
          title={this.props.title}
          description={this.props.description}
        />
      </Card>
    );
  }
}

export default CardBee;
