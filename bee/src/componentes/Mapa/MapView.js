import React, { Component } from "react";
import {
  GoogleMap,
  Marker,
  withScriptjs,
  withGoogleMap
} from "react-google-maps";
import SearchBox from "react-google-maps/lib/components/places/SearchBox";
import Search from "antd/lib/input/Search";
import pin from "../../images/pin.png";

/* global google */

class MapView extends Component {
  state = {
    isMarkerShown: true,
    positionMap: { lat: -6.1123, lng: -38.2052 },
    zoom: 8
  };

  componentDidMount() {
    this.delayedShowMarker();
  }

  componentWillReceiveProps = netxProps => {
    this.setState({
      positionMap: { lat: netxProps.lat, lng: netxProps.lng },
      zoom: netxProps.zoom
    });
  };

  // setIsDefaultCenter = (false) => {

  // }
  // setZoom = (15) => {

  // }

  // setCenter = (lat, lng) => {

  // }

  delayedShowMarker = () => {
    setTimeout(() => {
      this.setState({ isMarkerShown: true });
    }, 1000);
  };

  handleSearch = event => {};

  setPositionCenterMap = (lat, lng) => {
    this.setState({ positionMap: { lat: lat, lng: lng }, zoom: 20 });
  };

  render() {
    const {
      onSearchBoxMounted,
      onPlacesChanged,
      onBoundsChanged,
      onRightClick,
      onMarkerClick,
      apiarios
    } = this.props;
    const { isMarkerShown, positionMap, zoom } = this.state;
    // const FaAnchor = require("react-icons/lib/fa/anchor");

    return (
      <GoogleMap
        // defaultZoom={8}
        zoom={zoom}
        //defaultCenter={this.state.positionMap}
        center={positionMap}
        onRightClick={onRightClick}
      >
        <SearchBox
          ref={onSearchBoxMounted}
          bounds={onBoundsChanged}
          controlPosition={google.maps.ControlPosition.TOP_RIGHT}
          onPlacesChanged={onPlacesChanged}
        >
          <Search
            placeholder="Pesquise por cidade ..."
            onSearch={value => console.log(value)}
            size="large"
            style={{ width: 300, marginTop: 10, marginRight: 10 }}
          />
        </SearchBox>
        {isMarkerShown && (
          <div>
            {apiarios &&
              apiarios.map(apiario => (
                <Marker
                  key={apiario.id}
                  position={{ lat: apiario.latitude, lng: apiario.longitude }}
                  animation={google.maps.Animation.DROP}
                  onClick={() => onMarkerClick(apiario.id)}
                  icon={pin}
                />
              ))}
          </div>
        )}
      </GoogleMap>
    );
  }
}

export default withScriptjs(withGoogleMap(MapView));
