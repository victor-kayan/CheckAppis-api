import React from "react";
import { Link } from "react-router-dom";

import { Breadcrumb, Icon } from "antd";

const BreadcrumbBee = props => {
  const mapa = props.mapa;

  const listItems = mapa.map(m => (
    <Breadcrumb.Item key={m.key}>
      <Link to={m.key}>
        <Icon type={m.icon} />
        <span>{m.name}</span>
      </Link>
    </Breadcrumb.Item>
  ));

  return <Breadcrumb style={{ margin: "16px 0" }}>{listItems}</Breadcrumb>;
};

export default BreadcrumbBee;
