import Vapor from 'laravel-vapor'

window.Vapor = Vapor;

Vapor.withBaseAssetUrl(import.meta.env.VITE_VAPOR_ASSET_URL)
