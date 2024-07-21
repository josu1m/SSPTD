   <style>
       table {
           border-collapse: collapse;
           width: 100%;
           max-width: 800px;
           margin: 0 auto;
       }

       th,
       td {
           border: 1px solid #ddd;
           padding: 8px;
           text-align: left;
       }

       th {
           background-color: #f2f2f2;
           font-weight: bold;
       }

       tr:nth-child(even) {
           background-color: #f9f9f9;
       }

       tr:hover {
           background-color: #f5f5f5;
       }
   </style>
   <table>
       <thead>
           <tr>
               <th>Nombre</th>
               <th>Edad</th>
               <th>Ciudad</th>
           </tr>
       </thead>
       <tbody>
           <tr>
               <td>Juan</td>
               <td>25</td>
               <td>Madrid</td>
           </tr>
           <tr>
               <td>María</td>
               <td>30</td>
               <td>Barcelona</td>
           </tr>
           <tr>
               <td>Pedro</td>
               <td>28</td>
               <td>Valencia</td>
           </tr>
       </tbody>
   </table>
   @push('css')

   @endpush