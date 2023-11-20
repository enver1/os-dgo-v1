

class javaSeñalEtica {
  constructor (  nombre,  titulo,   latitud,  longitud,  descripcion1,  color, img ){
    this.nombre = nombre;
    this.titulo = titulo;
    this.latitud = latitud;
    this.longitud = longitud;
    this.descripcion1 = descripcion1;
    this.color = color;
    this.img = img;
  }

  get   getNombre  ()   {
     return this.nombre;
   }

     get   getTitulo  ()   {
     return this.titulo;
   }

     get   getLatitud  ()   {
     return this.latitud;
   }

     get   getLongitud  ()   {
     return this.longitud;
   }

  get   getDescripcion1  ()   {
     return this.descripcion1;
   }

     get   getColor  ()   {
     return this.color;
   }

  get   getImg  ()   {
     return this.img;
   }



}

