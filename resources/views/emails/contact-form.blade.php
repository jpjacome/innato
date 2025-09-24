<p>Nuevo mensaje desde el formulario de contacto:</p>
<p><strong>Nombre:</strong> {{ $data['nombre'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Mensaje:</strong></p>
<p>{!! nl2br(e($data['mensaje'])) !!}</p>
<p><strong>Newsletter:</strong> {{ isset($data['newsletter']) && $data['newsletter'] ? 'Sí' : 'No' }}</p>
